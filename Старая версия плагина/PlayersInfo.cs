using System;
using System.IO;
using System.Text;
using System.Text.Json;
using CounterStrikeSharp.API;
using CounterStrikeSharp.API.Core;
using System.Threading.Tasks;
using YamlDotNet.Serialization;
using MySqlConnector;
using Dapper;

namespace PlayerInfoNamespace
{
    public class PlayerInfo : BasePlugin
    {
        private const string PluginAuthor = "PISEX";
        private const string PluginName = "[PlayersInfo]";
        private const string PluginVersion = "2.0.7";
        private const string DbConfigFileName = "config.json";
        private DatabaseConfig? dbConfig;
        public override void Load(bool hotReload)
        {
            base.Load(hotReload);
            CreateDbConfigIfNotExists();
            dbConfig = DatabaseConfig.ReadFromJsonFile(Path.Combine(ModuleDirectory, DbConfigFileName));
            RegisterListener<Listeners.OnClientConnected>(OnClientConnected);
            RegisterEventHandler<EventPlayerDisconnect>(OnPlayerDisconnect);
            CreateTable();

            CreateDbConfigIfNotExists();
            dbConfig = DatabaseConfig.ReadFromJsonFile(Path.Combine(ModuleDirectory, DbConfigFileName));
        }

        private async Task UpdatePlayerConnectionAsync(int userid, string steamId, string playerName)
        {
            try
            {
                using (var connection = new MySqlConnection(ConnectionString))
                {
                    await connection.OpenAsync();
                    var insertQuery = $"INSERT INTO {dbConfig.Name} (userid, steam, name, server_id) VALUES (@UserID, @SteamID, @Name, {dbConfig.ServerID});";
                    await connection.ExecuteAsync(insertQuery, new { UserID = userid, SteamID = steamId, Name = playerName});
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine($"Error in UpdatePlayerConnectionAsync: {ex.Message}");
            }
        }

        private void OnClientConnected(int playerSlot)
        {
            var player = Utilities.GetPlayerFromSlot(playerSlot);
            if (player != null && !player.IsBot)
            {
                var steamId64 = player.SteamID.ToString();
                UpdatePlayerConnectionAsync(player.UserId.Value, steamId64, player.PlayerName);
            }
        }

        private async Task UpdatePlayerDisconnectAsync(int UserID, string steamId)
        {
            try
            {
                using (var connection = new MySqlConnection(ConnectionString))
                {
                    await connection.OpenAsync();
                    var updateQuery = $"DELETE FROM {dbConfig.Name} WHERE steam = @SteamID AND server_id = {dbConfig.ServerID} AND userid = {UserID};";
                    await connection.ExecuteAsync(updateQuery, new { SteamID = steamId });
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine($"Error in UpdatePlayerDisconnectAsync: {ex.Message}");
            }
        }
        private HookResult OnPlayerDisconnect(EventPlayerDisconnect disconnectEvent, GameEventInfo info)
        {
            if (disconnectEvent?.Userid != null && !disconnectEvent.Userid.IsBot)
            {
                var steamId64 = disconnectEvent.Userid.SteamID.ToString();

                UpdatePlayerDisconnectAsync(disconnectEvent.Userid.UserId.Value, steamId64);
            }

            return HookResult.Continue;
        }

        private void CreateDbConfigIfNotExists()
        {
            string configFilePath = Path.Combine(ModuleDirectory, DbConfigFileName);
            if (!File.Exists(configFilePath))
            {
                var config = new DatabaseConfig
                {
                    DbHost = "YourHost",
                    DbUser = "YourUser",
                    DbPassword = "YourPassword",
                    DbName = "YourDatabase",
                    DbPort = "3306"
                };

                string jsonConfig = JsonSerializer.Serialize(config, new JsonSerializerOptions { WriteIndented = true });
                File.WriteAllText(configFilePath, jsonConfig);
                Console.WriteLine("Database configuration file created.");
            }
        }

        private void CreateTable()
        {
            using (var connection = new MySqlConnection(ConnectionString))
            {
                connection.Open();

                var createTableQuery = string.Format(SQL_CreateTable, $"{dbConfig.Name}");
                connection.Execute(createTableQuery);
                var ClearTable = string.Format("DELETE FROM `{0}` WHERE server_id = {1}", $"{dbConfig.Name}", dbConfig.ServerID);
                connection.Execute(ClearTable);
            }
        }

        private string ConnectionString
        {
            get
            {
                if (dbConfig?.DbHost == null || dbConfig?.DbUser == null || dbConfig?.DbPassword == null || dbConfig?.DbName == null || dbConfig?.DbPort == null)
                    throw new InvalidOperationException("Database configuration is not properly set.");

                return $"Server={dbConfig.DbHost};Port={dbConfig.DbPort};User ID={dbConfig.DbUser};Password={dbConfig.DbPassword};Database={dbConfig.DbName};";
            }
        }

        private const string SQL_CreateTable = "CREATE TABLE IF NOT EXISTS `{0}` ( `steam` varchar(22) PRIMARY KEY, `name` varchar(32), `server_id` int NOT NULL DEFAULT 0, `userid` int NOT NULL);";
        public override string ModuleAuthor => PluginAuthor;
        public override string ModuleName => PluginName;
        public override string ModuleVersion => PluginVersion;
    }
    public class DatabaseConfig
    {
        public string? DbHost { get; set; }
        public string? DbUser { get; set; }
        public string? DbPassword { get; set; }
        public string? DbName { get; set; }
        public string? DbPort { get; set; }
        public string? Name { get; set; } = "pi_players";

        public int? ServerID { get; set; } = 1;

        public static DatabaseConfig ReadFromJsonFile(string filePath)
        {
            string jsonConfig = File.ReadAllText(filePath);
            return JsonSerializer.Deserialize<DatabaseConfig>(jsonConfig) ?? new DatabaseConfig();
        }
    }
}
<?php

function ConnectToDabase()
{
	/* Get environment variables (defined in Azure App Service Settings) for Azure SQL Database connection */
	/* Further info: https://docs.microsoft.com/en-us/azure/app-service-web/web-sites-configure#application-settings */
	$serverName = getenv("mssqlserver"); // In the form of: sqlservername.database.windows.net
	$connectionOptions = array(
		"Database" => getenv("dbName"),
		"Uid" => getenv("dbUsername"),
		"PWD" => getenv("dbPassword")
	);

	// Connect to Azure SQL Database
	$conn = sqlsrv_connect($serverName, $connectionOptions);

	return $conn;
}
?>
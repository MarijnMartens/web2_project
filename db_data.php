<?php 
    class DB {
        const USERNAME = 'b638e6ea6511d6';
        const PASSWORD = 'ebd8654c';
        const HOSTNAME = 'eu-cdbr-azure-west-b.cloudapp.net';
        
        public static function getConnectionString($dbName='cdb_f8188f18d4')
        {
            return "mysql:host=" . self::HOSTNAME . "; dbname=" . $dbName;
        }
    }

?>

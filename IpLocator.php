<?php 

class IpLocator{

    public $data;

    function __construct($data, $db) {
        $this->db = $db;
        $this->data = (object) $data;
    }

    public function getLocation(){

        // ***** Test with example:
        // http://api-v2.rboptions.com/locator/213.136.90.209
        $longIp = intval(ip2long(new Ip($this->data->ip)));

        //$res = $this->db->cmd("SELECT `countryName`,`region`,`city` FROM `ip2location` WHERE '{$longIp}' BETWEEN `beginIp` AND `endIp` LIMIT 1;");
        /*$sql ="SELECT i.`countryName`,i.`region`,i.`city`,i.`countryISO2` AS iso,
                        c.`id` AS countryId, c.`currency`, c.`prefix`
                FROM `ip2location` AS i
                LEFT JOIN spot_countries AS c ON c.iso = i.countryISO2
                WHERE {$longIp}
                BETWEEN `beginIp` AND `endIp` LIMIT 1;";*/

        $sql = "SELECT i.`countryName`,i.`province`,i.`city`,i.`countryISO2` AS iso,
                        c.`id` AS countryId, c.`currency`, c.`prefix`
                FROM `ip_countries` AS i
                LEFT JOIN spot_countries AS c ON c.iso = i.countryISO2
                WHERE CONTAINS(ip_range, Point('$longIp', 1)) LIMIT 1";
                // WHERE `seg_1`= {$ipSegment_1} AND {$longIp} BETWEEN `beginIp` AND `endIp` LIMIT 1;";

        $res = $this->db->cmd($sql);
        //$res = $this->db->cmd("SELECT `countryName`,`region`,`city` FROM `ip2location` WHERE INET_ATON('{$this->data->ip}') BETWEEN `beginIp` AND `endIp` LIMIT 1;");
        //$res = $this->db->cmd("call LocationByIp('{$this->data->ip}');");

        if($res != 0)
            return json_encode($this->db->fetch_assoc($res));
        else
            return '{}';
        
    }
}

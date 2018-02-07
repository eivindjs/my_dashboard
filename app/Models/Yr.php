<?php
namespace App\Models;

set_time_limit(60);

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;
use Storage;

class Yr extends Model {

    private $http_url = "http://www.yr.no/sted/Norge/";
    private $xml_hour = "varsel_time_for_time.xml";
    private $xml_week = "varsel.xml";
    private $xml;
    private $cache_file = "yr_data";
    //Påkrevd
    public $fylke;
    public $kommune;
    public $place;

    protected $type = "hour"; //time for time, eller vanlig

    /**
     * Undocumented function
     *
     * @return void
     */
    private function parse(){
        if(!$this->fylke || !Yr::isValidFylke($this->fylke))
            throw new Exception("Feil!. Mangler fylke");
        if(!$this->kommune)
            throw new Exception("Feil!. Mangler kommune");
        if(!$this->place)
            throw new Exception("Feil!. Mangler sted");
        
        $xml_type = $this->type == "hour" ? $this->xml_hour : $this->xml_week;
        $url = $this->http_url . $this->fylke . DIRECTORY_SEPARATOR . $this->kommune . DIRECTORY_SEPARATOR . $this->place . DIRECTORY_SEPARATOR . $xml_type;
        $file_name = $this->cache_file . $xml_type;
        $content = false;

        //Legge til error handling. ved feil fylke osv returner xml error node
        $time = Storage::lastModified($file_name);
        $now = Carbon::now();
        $time = Carbon::createFromTimestamp($time);
        if($now->diffInHours($time) < 3 && Storage::exists($file_name) && ($file = Storage::get($file_name))){
            $content = $file;
        } else {
            $content = @file_get_contents($url);
        }
        if(!$content)
            throw new Exception("Kunne ikke hente yr data fra url");
        
        $xml_data = simplexml_load_string($content);
        if(isset($xml_data->error) && $xml_data->error)
            throw new Exception("Kunne ikke finne sted. Kan skyldes feil ved fylke, kommune eller sted/by");
        
        Storage::disk('local')->put($file_name, $content);
        
        $this->xml = $xml_data;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getForecastTabularAttribute(){
        $this->parse();
        //text og tabular
        $tabular = array();
        $tab_xml = $this->xml->forecast->tabular;
        foreach($tab_xml->time as $time){
            $tabular[] = array(
                'time' => array(
                    'from' => (string)$time['from'],
                    'to' => (string)$time['to']
                ),
                'symbol' => array(
                    'number' => (string)$time->symbol['number'],
                    'numberEx' => (string)$time->symbol['numberEx'],
                    'name' => (string)$time->symbol['name'],
                    'var' => (string)$time->symbol['var']
                ),
                'precipitation' => array(
                    'value' => (string)$time->precipitation['value'],
                    'minvalue' => (string)$time->precipitation['minvalue'],
                    'maxvalue' => (string)$time->precipitation['maxvalue']
                ),
                'windDirection' => array(
                    'deg' => (string)$time->windDirection['deg'],
                    'code' => (string)$time->windDirection['code'],
                    'name' => (string)$time->windDirection['name']
                ),
                'windSpeed' => array(
                    'mps' => (string)$time->windSpeed['mps'],
                    'name' => (string)$time->windSpeed['name']
                ),
                'temperature' => array(
                    'unit' => (string)$time->temperature['unit'],
                    'value' => (string)$time->temperature['value']
                ),
                'pressure' => array(
                    'unit' => (string)$time->pressure['unit'],
                    'value' => (string)$time->pressure['value']
                )
            );
        }
        return $tabular;
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getForecastTextAttribute(){
        $this->parse();

        $text = array();
        $text_xml = $this->xml->forecast->text->location;
        foreach($text_xml->time as $time){
            $text[] = array(
                'time' => array(
                    'from' => (string)$time['from'],
                    'to' => (string)$time['to']
                ),
                'title' => (string)$time->title,
                'body' => (string)$time->body
            );
        }
        return $text;
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getLocationAttribute(){
        $this->parse();
        $location = $this->xml->location;
        $loc_array = array(
            'name' => (string)$location->name,
            'type' => (string)$location->type,
            'country' => (string)$location->country,
            'timezone' => array(
                'id' => (string)$location->timezone['id'],
                'utcoffsetMinutes' => (string)$location->timezone['utcoffsetMinutes']
            ),
            'location' => array(
                'altitude' => (string)$location->location['altitude'],
                'latitude' => (string)$location->location['latitude'],
                'longitude' => (string)$location->location['longitude']
            )
        );
        return $loc_array;
    }
    /**
     * Credit node. 
     *
     * @return void
     */
    public function getCreditAttribute(){
        $this->parse();
        $credit_xml = $this->xml->credit;
        $credit = array(
            'url' => (string)$credit_xml->link['url'],
            'text' => (string)$credit_xml->link['text']
        );
        return $credit;
    }
    /**
     * Meta node. Fortelle sist gang xml'en ble oppdatert og neste oppdatering
     *
     * @return single array
     */
    public function getMetaAttribute() {
        $this->parse();
        $meta_xml = $this->xml->meta;
        $meta = array(
            'lastupdate' => (string)$meta_xml->lastupdate,
            'nextupdate' => (string)$meta_xml->nextupdate
        );
        return $meta;
    }

    public function getNoke(){

    }

    public static function getFylker(){
        return array(
            'Østfold',
            'Akershus',
            'Oslo',
            'Hedmark',
            'Oppland',
            'Buskerud',
            'Vestfold',
            'Telemark',
            'Aust-Agder',
            'Vest-Agder',
            'Rogaland',
            'Hordaland',
            'Sogn_og_Fjordane',
            'Møre_og_Romsdal',
            'Trøndelag',
            'Nordland',
            'Troms',
            'Finnmark'
        );
    }

    public static function isValidFylke($fylke) {
        $fylker = self::getFylker();
        foreach($fylker as $f){
            if(strtolower($fylke) == strtolower($f) || strtolower(str_replace(" ","_",$fylke)) == strtolower($f))
                return true;
        }
        return false;
    }

}
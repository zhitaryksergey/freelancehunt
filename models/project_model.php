<?php
if(!defined('IRB_KEY'))
{
    header("HTTP/1.1 404 Not Found");
    exit(file_get_contents('./404.html'));
}

class Project_Model
{

    /**
     * @var integer
     */
    public $HttpCode              = 1;

    /**
     * @var array
     */
    public $Currency              = [
        'RUR' => 'RUB'
    ];

    /**
     * @var array
     */
    public $Privat                = [];
    /**
     * @var integer
     */
    private $NumPage              = 1;

    /**
     * @var array
     */
    public $AdditionalParameters = [];

    /**
     * @var array
     */
    public $Category             = [];

    /**
     * @var string
     */
    private $Endpoint            = 'https://api.freelancehunt.com/v2/projects';

    /**
     * @var array
     */
    private $connectionOptions;

    public function __construct($page = 1, $category = [])
    {
        $this->NumPage  = (int)$page;

        $this->Category = $category;

        $privat = file_get_contents('https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5');
        if($privat) {
            $privat = json_decode($privat);
            foreach($privat as $item) {
                $Currency = isset($this->Currency[$item->ccy]) ? $this->Currency[$item->ccy] : $item->ccy;
                $this->Privat[$Currency]['sale'] = $item->sale;
                $this->Privat[$Currency]['buy'] = $item->buy;
            }
        }
    }

    public function getChart()
    {
        $result = mysqlQuery("SELECT 
            (SELECT count(*) cnt from Projects where `budget_UAH` < 500) AS cnt500, 
            (SELECT count(*) cnt from Projects where `budget_UAH` >= 500 AND `budget_UAH` < 1000) AS cnt1000,
            (SELECT count(*) cnt from Projects where `budget_UAH` >= 1000 AND `budget_UAH` < 5000) AS cnt5000,
            (SELECT count(*) cnt from Projects where `budget_UAH` > 5000) AS cntMore");
        return mysqli_fetch_object($result);
    }

    public function cleanTable()
    {
        mysqlQuery("TRUNCATE TABLE Projects");
    }

    public function setPage($page)
    {
        $this->NumPage = (int)$page;
    }

    public function saveData($data)
    {
        mysqlQuery("INSERT INTO Projects (
                    id,
                    name,
                    description,
                    link,
                    budget_UAH,
                    budget,
                    currency,
                    first_name,
                    last_name,
                    login
        )".
        " VALUES " . implode(',', $data) .
        " ON DUPLICATE KEY UPDATE 
                name = VALUES(name), 
                description = VALUES(description),
                link = VALUES(link),
                budget_UAH = VALUES(budget_UAH),
                budget = VALUES(budget),
                currency = VALUES(currency),
                first_name = VALUES(first_name),
                last_name = VALUES(last_name),
                login = VALUES(login)");
    }

    public function getProjects()
    {
        if(!empty($this->Category)) {
            $this->AdditionalParameters['filter']['skill_id'] = implode(',',$this->Category);
        }

        $this->AdditionalParameters['page']['number'] = $this->NumPage;

        $Url = $this->Endpoint . '?'. http_build_query($this->AdditionalParameters);

        $request = $this->request('GET', $Url, ['headers' => [
            "Authorization: Bearer " . API_TOKEN,
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/json',
        ]]);

        return ($request ? json_decode($request) : []);

    }

    public function getBudget($id)
    {
        $Url = $this->Endpoint . '/' . $id;

        $request = $this->request('GET', $Url, ['headers' => [
            "Authorization: Bearer " . API_TOKEN,
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/json',
        ]]);

        return ($request ? json_decode($request) : []);
    }

    /**
     * Make request
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return string
     * @throws Exception
     */
    public function request($method = 'GET', $uri = '', array $options = [])
    {
        ob_start();
        $curl = curl_init();

        $curlOptions = $this->connectionOptions;

        $curlOptions[CURLOPT_URL] = $uri;
        $curlOptions[CURLOPT_CUSTOMREQUEST] = $method;

        if (isset($options['query'])) {
            $curlOptions[CURLOPT_POSTFIELDS] = $options['query'];
        }

        if (isset($options['headers'])) {
            $curlOptions[CURLOPT_HTTPHEADER] = $options['headers'];
        }

        if (isset($options['credentials'])) {
            $curlOptions[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;
            $curlOptions[CURLOPT_USERPWD] = $options['credentials'];
        }

        curl_setopt_array($curl, $curlOptions);

        $response = curl_exec($curl);

        $this->HttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (!empty($errors = curl_error($curl))) {
            throw new Exception($errors);
        }

        curl_close($curl);

        return ob_get_clean();
    }

}


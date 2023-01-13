<?php
namespace Vineet\MathmaticalOperation;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Vineet\MathmaticalOperation\Exception\DataException;
use Vineet\MathmaticalOperation\Exception\GeneralException;
use Vineet\MathmaticalOperation\Exception\InputException;
use Vineet\MathmaticalOperation\Exception\NetworkException;
use Vineet\MathmaticalOperation\Exception\OrderException;
use Vineet\MathmaticalOperation\Exception\PermissionException;
use Vineet\MathmaticalOperation\Exception\TokenException;
class ConnectAPI
{

    # Position Type
    public const POSITION_TYPE_DAY = "day";
    public const POSITION_TYPE_OVERNIGHT = "overnight";

    private $baseUrl = "https://api.sharekhan.com/skapi";

    /** @var String */
    private $loginUrl = "https://kite.trade/connect/login";


    public const VERSION = "3.2.0";
    // API route map.
    /** @var array */
    private $routes = [
        "services.reports"=>"/services/reports/{customerId}"
    ];
      // Instance variables
    /** @var int */
    private $timeout;

    /** @var mixed */
    private $apiKey;

    /** @var mixed */
    private $accessToken;

    /** @var mixed */
    private $debug;
    public function __construct(
        string $apiKey,
        string $accessToken = null,
        string $root = null,
        bool $debug = false,
        int $timeout = 7,
        GuzzleHttp\Client $guzzleClient = null
    ) {
        $this->apiKey = $apiKey;
        $this->accessToken = $accessToken;
        $this->debug = $debug;
        $this->sessionHook = null;
        $this->timeout = $timeout;
        $this->guzzleClient = $guzzleClient; 

        if ($root) {
            $this->baseUrl = $root;
        }
    }
    public function getApi()
    {
       $url="https://api.sharekhan.com/skapi/services";
       $client = new \GuzzleHttp\Client();
       try{
        $res = $client->request('GET', $url);
       }catch(Exception $e){
        die();
          throw $e;
       }
       echo $res;
    
    }

    //Get Request
    private function get(string $route, array $params = [], string $headerContent = '')
    {
        return $this->request($route, "GET", $params, $headerContent);
    }

    // request URL
    private function request(string $route, string $method, array $params, string $headerContent)
    {
        $uri = $this->routes[$route];
        // 'RESTful' URLs.
        if (strpos($uri, "{") !== false) {
            foreach ($params as $key => $value) {
                $uri = str_replace("{" . $key . "}", (string) $value, $uri);
            }
        }
        $url = $this->baseUrl . $uri;
        if ($this->debug) {
            print("Request: " . $method . " " . $url . "\n");
            var_dump($params);
        }
        // Set the header content type
        if ($headerContent) {
            $content_type = $headerContent;
        } else {
            // By default set header content type to be form-urlencoded
            $content_type = "application/json";
        }

        // Prepare the request header
        $request_headers = [
            "Content-Type" => $content_type,
            "User-Agent" => "phpkiteconnect/" . self::VERSION,
            "X-Kite-Version" => 3,
        ];

        if ($this->apiKey && $this->accessToken) {
            $request_headers["Authorization"] = "token " . $this->apiKey . ":" . $this->accessToken;
        }
        $resp = $this->guzzle($url, $method, $request_headers, $params, $this->guzzleClient);

        $headers = $resp["headers"];
        $result = $resp["body"];

        if ($this->debug) {
            print("Response :" . $result . "\n");
        }
        if (empty($headers["Content-Type"])) {
            throw new DataException("Unknown content-type in response");
        } elseif (strpos($headers["Content-Type"][0], "application/json") !== false) {
            $json = json_decode($result);
            if (!$json) {
                throw new DataException("Couldn't parse JSON response");
            }

            // Token error.
            if ($json->status == "error") {
                if ($headers["status_code"] == 403) {
                    if ($this->sessionHook) {
                        $this->sessionHook->call($this);

                        return null;
                    }
                }
                $this->throwSuitableException($headers, $json);
            }
            if($json->status!=200){
                $this->throwSuitableException($headers, $json);
            }
            return $json->data;
        } elseif (strpos($headers["Content-Type"][0], "text/csv") !== false) {
            return $result;
        } else {
            throw new DataException("Invalid response: " . $result, $headers["status_code"]);
        }
    }

    //guzzle client
    private function guzzle(string $url, string $method, ?array $headers, $params = null, $guzzleClient = null): array
    {
        if ($guzzleClient) {
            $client = $guzzleClient;
        } else {
            $client = new Client(['headers' => $headers, 'timeout' => $this->timeout]);
        }
        // declare http body array
        $body_array = [];
        if ($method == "POST" || $method == "PUT") {
            // send JSON body payload for JSON content-type requested
            if ($headers['Content-Type'] == 'application/json') {
                $body_array = ['body' => implode(" ", $params)];
            } else {
                $body_array = ['form_params' => $params];
            }
        } elseif ($method == "GET" || $method == "DELETE") {
            $payload = http_build_query($params && is_array($params) ? $params : []);
            // remove un-required url encoded strings
            $payload = preg_replace("/%5B(\d+?)%5D/", "", $payload);
            $body_array = ['query' => $payload];
        }
        try {
            $response = $client->request($method, $url,$body_array);
        } catch (RequestException $e) {
            // fetch all error response field
            $response = $e->getResponse();
        }
         try {

            $result = $response->getBody()->getContents();
            $response_headers = $response->getHeaders();
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }
        // add Status Code in response header
        $response_headers['status_code'] = $response->getStatusCode();
        return ["headers" => $response_headers, "body" => $result];
    }


    //Get All orders of day
    public function getAllOrdersOfDay(string $customerId): array
    {
        return $this->formatResponseArray($this->get("services.reports",["customerId" => $customerId]));
    }

    private function formatResponseArray($data): array
    {
        $results = [];
        foreach ($data as $k => $item) {
            $results[$k] = $this->formatResponse($item);
        }
        return $data;
    }
    private function throwSuitableException(array $headers, $json)
    {
        echo json_encode($json);
        die;
    }
}

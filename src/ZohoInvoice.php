<?php

namespace Babaweb\ZohoInvoice;

use Exception;
use GuzzleHttp\Client;

class ZohoInvoice
{
    private $baseUrl;
    private $client;
    private $httpMethod = 'POST';
    private $authToken = 'POST';
    private $organizationId = 'POST';

    /**
     * ZohoInvoice constructor.
     */
    public function __construct()
    {
        $this->setBaseUrl(config('zohoinvoice.baseurl') . '/');
        $this->setOrganizationId(config('zohoinvoice.organization_id'));
        $this->setAuthToken(config('zohoinvoice.authtoken'));
        $this->setClient();
    }

    /**
     * Setter of baseUrl attribute
     *
     * @param $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Getter of baseUrl attribute
     *
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Setter of client attribute
     *
     * @param $client
     */
    public function setClient($client)
    {
        if (!$client) {
            $this->client = new Client(['base_uri' => $this->getBaseUrl()]);
        }

        $this->client = $client;
    }

    /**
     * Getter of client attribute
     *
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Setter of httpMethod attribute
     *
     * @param $httpMethod
     */
    public function setHttpMethod($httpMethod)
    {
        $this->httpMethod = $httpMethod;
    }

    /**
     * Getter of httpMethod attribute
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * Setter of authToken attribute
     *
     * @param $authToken
     */
    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;
    }

    /**
     * Getter of authToken attribute
     *
     * @return string
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * Setter of organizationId attribute
     *
     * @param $organizationId
     */
    public function setOrganizationId($organizationId)
    {
        $this->organizationId = $organizationId;
    }

    /**
     * Getter of organizationId attribute
     *
     * @return string
     */
    public function getOrganizationId()
    {
        return $this->organizationId;
    }



    /**----------**/


    /**
     * Return the contacts list of the organization
     *
     * @return mixed
     */
    public function getContacts()
    {
        $this->setHttpMethod('GET');

        $resource['resource'] = 'contacts';

        return $this->call($resource);
    }

    /**
     * Return the invoices list of the organization
     *
     * @param $customer_id
     * @return mixed
     */
    public function getInvoices($customer_id)
    {
        $this->setHttpMethod('GET');

        $resource['resource'] = 'invoices';

        $params['customer_id'] = $customer_id;

        return $this->call($resource, $params);
    }

    /**
     * Return the invoice by its ID
     *
     * @param $invoice_id
     * @return mixed
     */
    public function getInvoice($invoice_id)
    {
        $this->setHttpMethod('GET');

        $resource['resource'] = 'invoices';
        $resource['id'] = $invoice_id;

        return $this->call($resource);
    }

    /**
     * Return the invoice payments by invoice ID
     *
     * @param $invoice_id
     * @return mixed
     */
    public function getInvoicePayments($invoice_id)
    {
        $this->setHttpMethod('GET');

        $resource['resource'] = 'invoices';
        $resource['id'] = $invoice_id;
        $resource['additional'] = 'payments';

        return $this->call($resource);
    }



    /**----------**/


    /**
     * Add a new item
     *
     * @param $parameters
     * @return mixed
     */
    public function createItem($parameters)
    {
        $this->setHttpMethod('POST');

        $resource['resource'] = 'items';

        $params['JSONString'] = json_encode($parameters);

        return $this->call($resource, $params);
    }

    /**
     * Update the item by its id
     *
     * @param $item_id
     * @param $parameters
     * @return mixed
     */
    public function updateItem($item_id, $parameters)
    {
        $this->setHttpMethod('PUT');

        $resource['resource'] = 'items';
        $resource['id'] = $item_id;

        $params['JSONString'] = json_encode($parameters);

        return $this->call($resource, $params);
    }

    /**
     * Create a new contact
     *
     * @param $parameters
     * @return mixed
     */
    public function createContact($parameters)
    {
        $this->setHttpMethod('POST');

        $resource['resource'] = 'contacts';

        $params['JSONString'] = json_encode($parameters);

        return $this->call($resource, $params);
    }

    /**
     * Update the contact by its id
     *
     * @param $contact_id
     * @param $parameters
     * @return mixed
     */
    public function updateContact($contact_id, $parameters)
    {
        $this->setHttpMethod('PUT');

        $resource['resource'] = 'contacts';
        $resource['id'] = $contact_id;

        $params['JSONString'] = json_encode($parameters);

        return $this->call($resource, $params);
    }

    /**
     * Create a new invoice
     *
     * @param $parameters
     * @return mixed
     */
    public function createInvoice($parameters)
    {
        $this->setHttpMethod('POST');

        $resource['resource'] = 'invoices';

        $params['JSONString'] = json_encode($parameters);

        return $this->call($resource, $params);
    }



    /**----------**/


    /**
     * Run a get call
     *
     * @param $resource
     * @param array $params
     * @return mixed
     */
    public function get($resource, $params = [])
    {
        $this->setHttpMethod('GET');

        return $this->call($resource, $params);
    }

    /**
     * Run a post call
     *
     * @param $resource
     * @param array $params
     * @return mixed
     */
    public function post($resource, $params = [])
    {
        $this->setHttpMethod('POST');

        return $this->call($resource, $params);
    }

    /**
     * Run a put call
     *
     * @param $resource
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function put($resource, $params = [])
    {
        if (!isset($resource['id'])) {
            throw new Exception('id is required');
        }

        $this->setHttpMethod('PUT');

        return $this->call($resource, $params);
    }

    /**
     * Run the call
     *
     * @param $resource
     * @param array $params
     * @param bool $rawResponse
     * @return mixed
     * @throws Exception
     */
    private function call($resource, $params = [], $rawResponse = false)
    {
        $url = $this->buildUrl($resource, $params);

        if (!isset($params['authtoken'])) {
            $params['authtoken'] = $this->getAuthToken();
        }

        if (!isset($params['organization_id'])) {
            $params['organization_id'] = $this->getOrganizationId();
        }

        $response = $this->getClient()->request($this->getHttpMethod(), $url);

        return $this->getResponse($response, $rawResponse);
    }

    /**
     * Build the url by the ressource array
     *
     * @param $resource
     * @param $params
     * @return string
     * @throws Exception
     */
    private function buildUrl($resource, $params)
    {
        if (!isset($resource['id'])) {
            return $this->getBaseUrl() . $resource['resource'] . '?' . $this->parseParams($params);
        }

        if (isset($resource['id']) && isset($resource['additional'])) {
            $url = $this->getBaseUrl() . $resource['resource'] . '/' . $resource['id'] . '/' . $resource['additional'];
        } else {
            $url = $this->getBaseUrl() . $resource['resource'] . '/' . $resource['id'];
        }

        return $url . '?' . $this->parseParams($params);
    }

    /**
     * Parse params array to build the query
     *
     * @param $params
     * @return string
     * @throws Exception
     */
    private function parseParams($params)
    {
        if (empty($params)) {
            throw new Exception ('No params specified.');
        }

        return http_build_query($params);
    }

    /**
     * Parse response
     *
     * @param $response
     * @param $rawResponse
     * @return mixed
     * @throws Exception
     */
    private function getResponse($response, $rawResponse)
    {
        if (!isset($response)) {
            throw new Exception('No response.');
        }

        if ($rawResponse) {
            return $response->getBody();
        }

        $response = \GuzzleHttp\json_decode($response->getBody());

        return $response;
    }
}
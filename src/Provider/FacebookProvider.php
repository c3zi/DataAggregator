<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 14/06/15
 * Time: 14:13
 */

namespace DataAggregator\Provider;

use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;
use DataAggregator\Entry;

class FacebookProvider implements ProviderInterface
{
    /**
     * @var FacebookSession
     */
    private $session;

    /**
     * @var string
     */
    private $facebookId;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var Entry
     */
    private $entry;

    /**
     * @param string $facebookId FacebookId value
     * @param string $accessToken Access token from Facebook
     */
    public function __construct($facebookId, $accessToken)
    {
        $this->facebookId = $facebookId;
        $this->accessToken = $accessToken;
        $this->entry = new Entry($facebookId);
        $this->initialize();
    }

    /**
     * {@inheritdoc}
     *
     * @throws FacebookRequestException
     * @throws \Exception
     */
    public function getPosts($limit = 10)
    {
        try {
            $data = (new FacebookRequest(
                $this->session, 'GET', '/' . $this->facebookId . '/posts?limit=' . $limit
            ))->execute()->getGraphObject()->getPropertyAsArray('data');

            /** @var \Facebook\GraphObject[] $data */
            foreach ($data as $post) {
                $this->entry->addMessage($post->getProperty('id'), $post->getProperty('message'));
            }

        } catch (FacebookRequestException $e) {
            $this->entry->addException($e->getMessage());
        } catch (\Exception $e) {
            $this->entry->addException($e->getMessage());
        }

        return $this->entry;
    }

    /**
     * Initializes facebook's connection.
     *
     * @throws FacebookRequestException
     * @throws \Exception
     */
    private function initialize()
    {

        FacebookSession::enableAppSecretProof(false);
        $session = new FacebookSession($this->accessToken);

        try {
            $session->validate();
        } catch (FacebookRequestException $e) {
            $this->entry->addException($e->getMessage());
        } catch (\Exception $e) {
            $this->entry->addException($e->getMessage());
        }

        $this->session = $session;
    }

}
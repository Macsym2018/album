<?php

namespace Drupal\album\Plugin\Block;

use \Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\ClientInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
//use GuzzleHttp\Client;
use Drupal\Core\Form\FormStateInterface;


/**
 * Provides a 'Album' Block.
 *
 * @Block(
 *   id = "album",
 *   admin_label = @Translation("Album block"),
 *   category = @Translation("Hello World"),
 * )
 */
class AlbumBlock extends BlockBase implements ContainerFactoryPluginInterface{

  /**
   * Guzzle\Client instance.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;


  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \GuzzleHttp\ClientInterface $http_client
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, \Drupal\album\AlbumService $http_client) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->httpClient = $http_client;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('album.album')
    );
  }



  public function getAllPhotos(){
    $response = $this->httpClient->request('GET', 'https://jsonplaceholder.typicode.com/photos');
    $albums=json_decode($response->getBody());

    return $albums;
  }

    public function build() {

      $config = $this->getConfiguration();

      if(isset($config['selected_album'])){

        $albumId=$config['selected_album'];

        $photos=$this->httpClient->getAlbumPhotos($albumId);

        $text='<ul>';

        foreach ($photos as $photo){
          $text.='<li><a href=" /album/'.$photo['id'].'">'.$photo['title'].'</a></li>';
        }

        $text.='</ul>';


        return [
          '#markup' => $this->t($text),
        ];
      }else{
        return [
          '#markup' => $this->t("Album did non select"),
        ];
      }
    }



  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();
    $albums=$this->httpClient->getAlbums();
    $options = array();

    foreach($albums as $p)
    {
      $options[$p->id] = $p->title;
    }

    $form['selected_album'] = [
      '#type' => 'select',
      '#title' => $this->t('Select album'),
      '#options'=>$options,
      '#default_value'=>isset($config['selected_album']) ? $config['selected_album'] : '',
    ];


    $form['new_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('You can change the name for selected album'),

    ];

    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);

    $config = $this->getConfiguration();
    //die($config);
    //var_dump($config);

    $values = $form_state->getValues();
    //die(var_dump($values['selected_album']));
    $this->configuration['selected_album'] = $values['selected_album'];
  }


}

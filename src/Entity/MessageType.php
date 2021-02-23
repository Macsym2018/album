<?php
/**
 * @file
 * Contains \Drupal\album\Entity\MessageType.
 */

namespace Drupal\album\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\album\Entity\MessageTypeInterface;

/**
 * Defines the profile type entity class.
 *
 * @ConfigEntityType(
 *   id = "message_type",
 *   label = @Translation("Message type"),
 *   handlers = {
 *     "list_builder" = "Drupal\album\MessageTypeListBuilder",
 *     "form" = {
 *       "default" = "Drupal\album\MessageTypeForm",
 *       "add" = "Drupal\album\MessageTypeForm",
 *       "edit" = "Drupal\album\MessageTypeForm",
 *       "delete" = "Drupal\album\MessageTypeForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "message_type",
 *   bundle_of = "message",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *   },
 *   links = {
 *     "delete-form" = "/admin/structure/message-types/{message_type}/delete",
 *     "edit-form" = "/admin/structure/message-types/{message_type}",
 *     "admin-form" = "/admin/structure/message-types/{message_type}",
 *     "collection" = "/admin/structure/message-types"
 *   }
 * )
 */

class MessageType extends ConfigEntityBundleBase implements MessageTypeInterface {

  /**
   * The announcement's message.
   *
   * @var string
   */
  protected $message;
  /**
   * {@inheritdoc|}
   */
  public function getMessage() {
    return $this->message;
  }

}

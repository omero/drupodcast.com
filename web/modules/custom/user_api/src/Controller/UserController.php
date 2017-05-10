<?php

namespace Drupal\user_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController.
 *
 * @package Drupal\user_api\Controller
 */
class UserController extends ControllerBase {

  /**
   * Users.
   *
   * @return string
   *   Return Hello string.
   */
  public function users() {
    $users = file_get_contents(__DIR__. '/../../data/users.json');

    return new Response($users);
  }

    public function user($email) {
        $users = file_get_contents(__DIR__. '/../../data/users.json');
        $users = json_decode($users, true);
        foreach ($users as $endPointUser) {

            if ($endPointUser['email'] !== $email) {
                continue;
            }

            if ($endPointUser['isActive']) {
                return new Response(json_encode([
                    'id' => $endPointUser['id'],
                    'email' => $endPointUser['email'],
                    'isValid' => true,
                    'message' => 'Login successfully.'
                ]));
            }

            return new JsonResponse([
                'isValid' => false,
                'message' => sprintf(
                    'Email address %s, no longer active.',
                    $email
                )
            ]);
        }

        return new JsonResponse([
            'isValid' => false,
            'message' => sprintf(
                'Email address %s, do not exists.',
                $email
            )
        ]);
    }

}

<?php namespace Talonon\Ooops\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response as SymphonyResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Talonon\Ooops\Exceptions\EntityNotFoundException;
use Talonon\Ooops\Exceptions\ExternalException;

trait ResponseWithJson {

  protected $checkXHR = true;
  protected $resultCode = SymphonyResponse::HTTP_OK;
  private $_isXHR;

  protected function dispatch(callable $delegate) {
    try {
      $result = $delegate(\Request::instance());
      if ($result instanceof Response || $result instanceof RedirectResponse) {
        return $result;
      } else if ($result instanceof View) {
        /** @var Response $response */
        $response = response($result->render());
        return $response->header('content-type', 'text/html');
      } else if (is_array($result) || $result instanceof \JsonSerializable) {
        return $this->respondObject($result, $this->resultCode);
      } else {
        return $this->respondJSON($result, $this->resultCode);
      }
    } catch (ExternalException $eex) {
      return $this->respondError($eex->getMessage(), SymphonyResponse::HTTP_BAD_REQUEST);
    } catch (EntityNotFoundException $enfex) {
      return $this->respondError($enfex->getMessage(), SymphonyResponse::HTTP_NOT_FOUND);
    } catch (HttpException $hex) {
      return $this->respondError($hex->getMessage(), $hex->getStatusCode());
    } catch (\Exception $ex) {
      return $this->dispatcherError($ex);
    }
  }

  protected function dispatcherError(\Exception $ex) {
    $debug = \Config::get('app.debug', false);
    $message = $debug ? $ex->getMessage() : 'Unexpected error occurred.';
    if ($this->_isXHR) {
      return $this->respondError($message, SymphonyResponse::HTTP_INTERNAL_SERVER_ERROR);
    } else {
      \App::abort(SymphonyResponse::HTTP_INTERNAL_SERVER_ERROR, $message);
    }
  }

  /**
   * Responds to the client that the AJAX request was successful.  Can optionally send a message, an id, and/or
   * an entity.
   * @param string|null $message
   * @param int|null $id
   * @param mixed $entity
   * @return mixed
   */
  protected function respondSuccess($message = null, $id = null, $entity = null) {
    $this->ensureXHR();
    $data['success'] = true;
    $message && ($data['message'] = $message);
    $id && ($data['id'] = $id);
    $entity && ($data['entity'] = $entity);
    return $this->respondObject($data);
  }

  /**
   * JSON Encodes the $thing and sends that string to the client with the pass status code.
   * @param mixed $entity
   * @param int $statusCode Any valid HTTP Response code.
   */
  protected function respondObject($entity, $statusCode = SymphonyResponse::HTTP_OK) {
    $this->ensureXHR();
    return $this->respondJSON(json_encode($entity), $statusCode);
  }

  /**
   * Sends a JSON string to the client with the passed status code.
   * @param $json string A JSON encoded string.
   * @param int $statusCode Any valid HTTP Response status code.  200, 404, 403 etc.
   */
  protected function respondJSON($json, $statusCode = SymphonyResponse::HTTP_OK) {
    $this->ensureXHR();
    return (new Response($json, $statusCode, $this->headers))
      ->header('Content-Type', 'application/json');
  }

  /**
   * Responds to the AJAX call witih a list of entities.  Assumes the call was successful, and will set success = 1
   * @param $list
   * @param int $statusCode
   * @return mixed
   */
  protected function respondList($list, $count = null, $total = null, $statusCode = SymphonyResponse::HTTP_OK) {
    $this->ensureXHR();
    return $this->respondObject(
      [
        'success' => true,
        'data'    => $list,
        'count'   => $count ?: count($list),
        'total'   => $total
      ], $statusCode);
  }

  /**
   * Respond with a success message and a URL for the browser to redirect to.
   * @param $to string URL to redirect to.
   * @return mixed
   */
  protected function respondSuccessRedirect($to, $message = null) {
    $this->ensureXHR();
    return $this->respondObject(
      ['success'  => true,
       'message'  => $message,
       'redirect' => $to]);
  }

  /**
   * Responds to the client that there was an error.  Includes a message to display to the user.
   * @param $message string or Array of strings.
   */
  protected function respondError($message, $statusCode = 500) {
    $this->ensureXHR();
    $data['success'] = false;
    $data['statusCode'] = $statusCode;
    $message && ($data['error'] = $message);
    return $this->respondObject($data, $statusCode);
  }

  protected function respondDownload($path, $filename, $type = 'application/csv') {
    $response = new BinaryFileResponse($path, 200, ['Content-Type' => $type], true, null, false, true, true);
    $response->setContentDisposition('inline', $filename);
    return $response;
  }

  /**
   * Checks the request headers to make sure they are properly formatted AJAX headers.  If they aren't we don't
   * want to serve the request and a BadRequest exception is thrown.
   * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
   */
  protected function ensureXHR() {
    if ($this->checkXHR && !$this->_isXHR) {
      throw new BadRequestHttpException();
    }
  }
}


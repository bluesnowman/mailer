<?php

/**
 * Copyright © 2011–2012 Spadefoot Team.
 * Copyright © 2015 Blue Snowman.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Ziminji\Core\Throwable\Runtime {

	/**
	 * This class represents a Runtime Exception.
	 *
	 * @access public
	 * @class
	 * @package Ziminji\Core\Throwable
	 * @version 2015-09-21
	 */
	class Exception extends \Exception implements \Ziminji\Core\IObject {

		/**
		 * This variable stores the code associated with the exception.
		 *
		 * @access protected
		 * @var int
		 */
		protected $code;

		/**
		 * This constructor creates a new runtime exception.
		 *
		 *     throw new \Ziminji\Core\Throwable\Runtime\Exception('Unable to find :uri', array(':uri' => $uri));
		 *
		 * @access public
		 * @param string $message                                   the error message
		 * @param array $variables                                  translation variables
		 * @param integer $code                                     the exception code
		 */
		public function __construct($message, array $variables = null, $code = 0) {
			parent::__construct(
				empty($variables) ? (string) $message : strtr( (string) $message, $variables),
				(int) $code
			);
			$this->code = (int) $code; // Known bug: http://bugs.php.net/39615
		}

		/**
		 * This method dumps information about the object.
		 *
		 * @access public
		 */
		public function __debug() {
			var_dump($this);
		}

		/**
		 * This method releases any internal references to an object.
		 *
		 * @access public
		 */
		public function __destruct() {
			unset($this->code);
		}

		/**
		 * This method returns whether the specified object is equal to the called object.
		 *
		 * @access public
		 * @param \Ziminji\Core\IObject $object                     the object to be evaluated
		 * @return boolean                                          whether the specified object is equal
		 *                                                          to the called object
		 */
		public function __equals($object) {
			return (($object !== NULL) && ($object instanceof \Ziminji\Core\Throwable\Runtime\Exception) && ((string) serialize($object) == (string) serialize($this)));
		}

		/**
		 * This method returns the name of the runtime class of this object.
		 *
		 * @access public
		 * @return string                                           the name of the runtime class
		 */
		public function __getClass() {
			return get_called_class();
		}

		/**
		 * This method returns the current object's hash code.
		 *
		 * @return string                                           the current object's hash code
		 */
		public function __hashCode() {
			return spl_object_hash($this);
		}

		/**
		 * This method returns the exception as a string.
		 *
		 * @access public
		 * @return string                                           a string representing the exception
		 */
		public function __toString() {
			return static::text($this);
		}

		/**
		 * This method returns the exception as a string.
		 *
		 * @access public
		 * @static
		 * @param \Exception $exception                             the exception to be processed
		 * @return string                                           a string representing the exception
		 */
		public static function text(\Exception $exception) {
			if ($exception !== null) {
				return sprintf('%s [ %s ]: %s ~ %s [ %d ]', get_class($exception), $exception->getCode(), strip_tags($exception->getMessage()), $exception->getFile(), $exception->getLine());
			}
			return '';
		}

	}

}

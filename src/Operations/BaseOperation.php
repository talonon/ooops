<?php
  namespace Talonon\Ooops\Operations {
    /**
     * Class BaseOperation.  The base class for all operations.  The constructor is used to pass in the values in the
     * operation.  The Execute does not return a value by design, not all operations will return a value.  Operations
     * that return a value should implement the ResultInterface, which defines a GetResult method for getting the result
     * of an operation.
     * The logic is wrapped into 4 distinct methods. Validation, Before Execute, Execute, and After Execute.
     *    The Validator validates the values passed into the constructor to make sure they are what is expected to
     *      execute the operation.  The validator should throw an exception if something does not validate, this will
     *      ensure that nothing else in the operation executes.
     *    Before Execute and After Execute are logical breakouts of what should happen before and after the logic in the
     *      operation is executed.  These could easily be included in the doExecute method, but by breaking it out it
     *      allows for a break out in requirements gathering (before), cleanup (after), and business logic (execute).
     *    The Executor must be defined in the inheriting class.  This is the meat of the operation, where the real magic
     *      happens.
     * @package Talonon\Framework\Operations
     */
    abstract class BaseOperation {

      /**
       * Executes the Operation.  This method does not return a result.  An operation that returns a result should
       * implement the ResultInterface.
       */
      public function Execute() {
        $this->validate();
        $this->beforeExecute();
        $this->doExecute();
        $this->afterExecute();
      }

      /**
       * Executes the business logic defined in the inheriting class(es).
       */
      protected abstract function doExecute();

      /**
       * Validates the information passed in by the constructor.  By default this does nothing.
       */
      protected function validate() {
      }

      /**
       * Used to load resources that are needed by the doExecute method.  By default this does nothing.
       */
      protected function beforeExecute() {
      }

      /**
       * Used for any cleanup or subsequent calls to be made after the doExecute.
       * (Example: Creating a foo then adding the bars to it in the AfterExecute).
       */
      protected function afterExecute() {
      }
    }
  }
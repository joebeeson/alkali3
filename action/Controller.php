<?php

    // Namespace, classes.
    namespace alkali3\action;

    /**
     * Controller
     *
     * Extension of the Lithium `Controller` object to provide common, reusable
     * functionality.
     *
     * @author Joe Beeson <jbeeson@gmail.com>
     */
    class Controller extends \lithium\action\Controller {

        /**
         * Action for creating a new record.
         *
         * By default the `success` function will redirect the request to
         * the `read` action for the newly created record.
         *
         * @param array $options
         * @return array
         * @access public
         */
        public function create($options = array())
        {
            if ($this->_classes['model']) {
                $options += array(
                    'Record'  => $this->_instance('model')->create(),
                    'failure' => function() {},
                    'success' => function($Record) {
                        $Model = $Record->model();
                        $this->redirect(
                            array(
                                'action' => 'read',
                                'id'     => $Record->{$Model::meta('key')}
                            ),
                            array(
                                'exit' => true
                            )
                        );
                    }
                );
                if ($this->request->data) {
                    if ($options['Record']->save($this->request->data)) {
                        $options['success']($options['Record']);
                    } else {
                        $options['failure']($options['Record']);
                    }
                }
            }
            return $options;
        }

        /**
         * Action for retrieving a record.
         *
         * By default the `failure` function will redirect the request to the
         * `index` action.
         *
         * @param mixed $id
         * @param array $options
         * @return array
         * @access public
         */
        public function read($id = null, $options = array())
        {
            $id = $id ?: $this->request->id;
            if ($this->_classes['model']) {
                $options += array(
                    'Record' => $this->_instance('model')->first($id),
                    'success' => function() {},
                    'failure' => function() {
                        $this->redirect(
                            array(
                                'action' => 'index'
                            ),
                            array(
                                'exit' => true
                            )
                        );
                    }
                );

                // Trigger the appropriate function based on our status.
                $options[$options['Record'] ? 'success' : 'failure']($options['Record']);
            }
            return $options;
        }

        /**
         * Action for updating a record.
         *
         * At the moment we "piggy back" on the `create` and `read` actions for
         * performing our operations.
         *
         * @param mixed $id
         * @param array $options
         * @return array
         * @access public
         */
        public function update($id = null, $options = array())
        {
            $id = $id ?: $this->request->id;
            return $this->create($this->read($id, $options));
        }

        /**
         * Action for deleting a record.
         *
         * @param mixed $id
         * @param array $options
         * @return array
         * @access public
         */
        public function delete($id = null, $options = array())
        {
            $id = $id ?: $this->request->id;
            if ($this->_classes['model']) {
                $options += $this->read($id, $options);
                $options[$options['Record']->delete() ? 'success' : 'failure'](
                    $options['Record']
                );
            }
            return $options;
        }

    }
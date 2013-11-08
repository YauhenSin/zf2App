<?php

namespace ZfcUser\Form;

use Zend\Form\Form;

class UserForm extends Form
{
    public function __construct()
    {
        parent::__construct('user');
        $this->setAttributes(array(
            'method' => 'post',
            'class' => 'form-horizontal'
        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'id' => 'title',
                'type' => 'text',
                'class' => 'form-control',
                'placeholder' => 'Enter album title'
            ),
            'options' => array(
            ),
        ));
    }
}
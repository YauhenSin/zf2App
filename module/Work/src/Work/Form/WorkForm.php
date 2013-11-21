<?php

namespace Work\Form;

use Zend\Form\Form;

class WorkForm extends Form
{
    public function __construct()
    {
        parent::__construct('work');
        $this->setAttribute('enctype', 'multipart/form-data');
//        $this->setAttribute('method', 'post');
        $this->setAttributes(array(
            'method' => 'post',
            'class' => 'form-horizontal'
        ));
        $this->add(array(
            'name' => 'workImage',
            'attributes' => array(
                'id' => 'workImage',
                'type' => 'file',
//                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'workName',
            'attributes' => array(
                'id' => 'workName',
                'type' => 'text',
                'class' => 'form-control',
                'placeholder' => 'Enter work name',
//                'data-provide' => 'typeahead',
//                'autocomplete' => "off",
            ),
        ));
        $this->add(array(
            'name' => 'workGenre',
            'type' => 'select',
            'options' => array(
                'empty_option' => 'Select genre',
                'value_options' => array(
                    '1' => 'one',
                    '2' => 'two',
                ),
            ),
            'attributes' => array(
                'id' => 'workGenre',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'workDescription',
            'attributes' => array(
                'id' => 'workDescription',
                'type' => 'textarea',
                'class' => 'form-control',
                'rows' => 6,
                'placeholder' => 'Enter work description',
            ),
            'options' => array(
            ),
        ));
        $this->add(array(
            'name' => 'workPrice',
            'attributes' => array(
                'id' => 'workPrice',
                'type' => 'text',
                'class' => 'form-control',
                'placeholder' => 'Enter work price',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Add',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}

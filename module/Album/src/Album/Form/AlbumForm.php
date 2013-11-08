<?php

namespace Album\Form;

use Zend\Form\Form;

class AlbumForm extends Form
{
    public function __construct()
    {
        parent::__construct('album');
//        $this->setAttribute('method', 'post');
        $this->setAttributes(array(
            'method' => 'post',
            'class' => 'form-horizontal'
        ));
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'artist',
            'attributes' => array(
                'id' => 'artist',
                'type' => 'text',
                'class' => 'form-control',
                'placeholder' => 'Enter artist name',
//                'data-provide' => 'typeahead',
                'autocomplete' => "off",
            ),
            'options' => array(
//                'label' => 'Artist'
            ),
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
//                'label' => 'Title'
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

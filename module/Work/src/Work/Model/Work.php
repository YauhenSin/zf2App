<?php

namespace Work\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Work implements InputFilterAwareInterface
{
    protected $_inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception('Not used');
    }

    public function getInputFilter()
    {
        if(!$this->_inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'workName',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'utf-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'workDescription',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'utf-8',
                            'min' => 1,
                            'max' => 600,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'workPrice',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'utf-8',
                            'min' => 3,
                            'max' => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'workImage',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'File\IsImage',
                        'options' => array(
                            'messages' => array(
                                'fileIsImageFalseType' => 'Please select a valid icon image to upload.',
                                'fileIsImageNotDetected' => 'The icon image is missing mime encoding, please verify you have saved the image with mime encoding.',
                            ),
                        ),
                    ),
                ),
            )));

            $this->_inputFilter = $inputFilter;
        }
        return $this->_inputFilter;
    }
}
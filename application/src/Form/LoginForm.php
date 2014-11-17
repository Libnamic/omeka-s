<?php
namespace Omeka\Form;

class LoginForm extends AbstractForm
{
    public function buildForm()
    {
        $translator = $this->getTranslator();

        $this->add(array(
            'name' => 'username',
            'type' => 'Text',
            'options' => array(
                'label' => $translator->translate('Username'),
            ),
            'attributes' => array(
                'required' => true,
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'options' => array(
                'label' => $translator->translate('Password'),
            ),
            'attributes' => array(
                'required' => true,
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type'  => 'Submit',
            'attributes' => array(
                'value' => $translator->translate('Log in'),
            ),
        ));

        $inputFilter = $this->getInputFilter();
        $inputFilter->add(array(
            'name' => 'username',
            'required' => true,
        ));
        $inputFilter->add(array(
            'name' => 'password',
            'required' => true,
        ));
    }
}
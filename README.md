# Magic Wizard for Symfony
Symfony has a great forms library. 
I think it lacks nothing and is very well achieved. Why is it not used more?
This library only tries to show its potential by integrating the solution with Vue.js.

## Instllation
In a Symfony project install it via composer
```
composer require promani\magic-wizard
```

## Requirements
- Forms
- Twig
- ExpressionLanguage

Only for check. Be sure to have a template for forms.
```
twig:
    form_themes: ['bootstrap_4_layout.html.twig']
```
## Implementation
First create a Flow class with a method getSteps with Steps
```php
use MagicWizardBundle\Model\Flow;

class DemoFlow extends Flow
{
	public function getSteps(): array
	{
		return [
			new FirstStep(),
			new SecondStep(),
		];
	}

}
```
The steps are something like this:
```php
use MagicWizardBundle\Model\Step;

class FirstStep extends Step
{
	public $title = 'First step';
	public $subtitle = 'subtitle';
	public $description = 'description';

	public function getFormType()
	{
		return Step1Type::class;
	}

}
```
As you can see, you also have to create a FormType but they are neither more nor less than the powerful Symfony [FormTypes](https://symfony.com/doc/current/forms.html)
    
By last add a class to your proyect that extends AbstractStepController
```php
use MagicWizardBundle\Controller\AbstractStepController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test", name="test_")
 */
class TestController extends AbstractStepController
{
	public static function getFlowClass(): string
	{
		return TestFlow::class;
	}
}
```
Did you notice the route? it is important that you do something very similar.

Go to see your Wizard:
![wizard](https://i.ibb.co/BN5GWS9/wizard.png "Demo")

The information that is sent by the form is validated with all the features that the forms have. 
If the form is valid, the UI go to the next step with no refresh and save the information sent in the session. 
The path ends when there are no more steps or a step has no more forms.

You can change the color, change the icon for a name or add a url to your logo. 
```
magic_wizard:
    color: '#FF5733'
    company_name: 'The wizard of steps' 
    logo_url: 'images/logo.png' ## with more priority between company_name
```
You can change the Flow template or the template of a single Step.

But you really want to change all the templates and make your own. See [documentation](https://symfony.com/doc/current/bundles/override.html#templates)

Additionally you can add callbacks for each Step. 
You may want to save the information in each case or maybe in the end. 
In your Step class add:
```php
public function getCallback()
{
    return function ($data) {
        $this->client->post('http://backend.url', $data);
    };
}
```
You can allow it to fail or the UI sends a [SweetAlert](https://sweetalert.js.org/) alert with the error.
```php
public function isAllowFail()
{
    return false;
}
```
Something like that work as follow:
```php
public function getCallback()
{
    return function ($data) {
        throw new \Exception(sprintf('You have sended %s fields', count($data)));
    };
}
```
![wizard](https://i.ibb.co/3pc7Kwj/wizard.png "Error alert")


You can skip a step with a condition. To do that, simply add:
```php
public function getNextStep()
{
    return FurtherStep::class;
}

public function condition()
{
    return 'data.name == "Rambo"';
}
```
To write the condition see Expression Language [documentation](https://symfony.com/doc/current/components/expression_language.html). 
You have in the data variable all the info of all Steps.
### In summary:
You have a few entrypoints prefixed by your router configuration in the controller:
`/prefix/form` For GET and the POST forms

`/prefix/clear` For clear all the information submited for the user

`/prefix/back` For go back only one Step

For this last endpoint may be you want implement a back button.

You are able to have many Controllers with diferent routes for diferent proposits. Not magic enought? Try it out!

### A case of use
Imagine your registration in several steps with complex logic between steps: Magic Wizard can Handle it.
The flow
```php
class RegistrationFlow extends Flow
{
	public function getSteps(): array
	{
		return [
			new UserInfoStep(),
			new AgeStep(),
			new ConfirmDataStep(),
			new SuccessStep(),
			new FilureStep(),
		];
	}

}
```
The condition and nextStep for second step:
```php
public function getCondition()
{
    return 'data.age > 13';
}

public function getNextStep()
{
    return FilureStep::class;
}
```
The formType for third step:
```php
class ConfirmDataType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    	{
    		$builder
    			->add('username', TextType::class, ['disabled' => 'true'])
    			->add('age', NumberType::class, ['disabled' => 'true'])
    			->add('submit', SubmitType::class)
    		;
    	}
}
```

At this point you hace this:
![wizard](https://i.ibb.co/wYrbTrN/wizard.png "Confirm data step")

The success callback for third step:
```php
public function getCallback()
{
    return function ($data, $container) {
        $em = $container->get('doctrine')->getManager();
        $user = new User($data['username'], $data['password']);
        $user->setAge($data['age']);
        $em->persist($user);
        $em->flush();
    };
}
```
The failure message for FailureStep:
```php
class FirstStep extends Step
{
	public $title = 'Sorry!';
	public $subtitle = 'You are too young for register with us';
	public $image = 'baby.png';
}
```

At last you get:

![wizard](https://i.ibb.co/rMVwR8c/wizard.png "Failure step")


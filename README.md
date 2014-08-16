HealthCheckComponent
====================

A generic HealthChecker component for use with Symfony2 and alike projects.

## Features
* Organizable tests in TestSuites and TestGroups.
* Customizable reporting.
* Customizable method of determining final success/health.
* The ability to intercept errors (useful for shoddy SOAP clients).
* A stateless service for executing test(s).

## Installation
### As a standalone repository
This method is generally used for development.

```
git clone https://github.com/tests-always-included/HealthCheckComponent.git HealthCheckComponent
/path/to/your/composer.phar install
```

### As a dependency
This method would include the component as part of your project.
**composer.json**
```
{
    ...
    dependencies: {
        ...,
        "tests-always-included/health-check": "@dev-master"
    }
}
```

Tell composer to update your project's vendors.
`/path/to/your/composer.phar install`


## Testing
Tests are written utilizing the **PHPUnit Framework**.
```
cd /path/to/your/clone/of-this-repository
./vendor/bin/phpunit -c .
```

## Usage

### Create some Test(s).

Each test must extend the abstract definition in this library.
No default implementation is provided.

**Example scenario**:
* Your project connects to a remote service.
* This remote service may require authentication.
* The health of your site depends on that authentication.

```
namespace My\Project\HealthCheck\Tests;

use TestsAlwaysIncluded\HealthCheck\Test\Test;

class MyTest extends Test
{
    public function execute()
    {
        // Example: Authentication check.
        $someService->authenticate();

        if ($someService->isAuthenticated()) {
            $this->pass('My service is authenticating as expected.');
            return;
        }

        if ($someService->timedOut()) {
            $this->fail('My service appears to be down.');
            return;
        }

        if ($someService->isNotConfigured()) {
            $this->skip('We might be running this from a lower environment.');
            return;
        }

        if ($someService->returnedGarbage()) {
            $this->error('My service is doing something I didnt expect.');
            return;
        }
    }
}
```

### Build up your TestSuite(s)
```
$test = new MyTest;
$testGroup = new TestGroup('RemoteServicesAreEverywhere');
$testGroup->addTest($test);
$testSuite = new TestSuite('ThisIsProbablyABundleInMyProject');
$testSuite->addTestGroup($testGroup);
```

### Attach the TestSuite(s) to your HealthCheck
```
$healthCheck = new HealthCheck;
$healthCheck->addTestSuite($testSuite);
```

### Define the reporting you'd like (if any).
```
// Example: A basic console dot-F reporter is included with the repo.
$reporter = new ConsoleOutputReporter();

// A second, optional argument allows you to alias the reporter.
// Otherwise, the Reporter's class name is used.
$healthCheck->registerReporter($reporter, 'consoleReporter');
```

### Execute the scenario you've created.
```
$runner = new HealthCheckRunner;
// You will most likely obtain an EventDispatcher from your DependencyInjection Container.
$runner->setEventDispatcher($eventDispatcher);
$runner->run($healthCheck);
```

### Determine if your system is Healthy.
```
// You can define your own strategies, as well.
// A simple PassFailSuccessStrategy is included with the repo.
$successStrategy = new PassFailSuccessStrategy();

echo $healthCheck->passed($successStrategy) ? 'Everything is AOK!' : 'Something might be wrong.';
```

## Future Consideration
* Allow a test to be skipped if a dependent test fails/passes/etc.
* Provide a default command implementation for executing test(s).
* Permit multiple instances of a Reporter to be attached (may be useful for outputting a simple and a detailed report in the same format).
* Provide a default loader for assembling a HealthCheck instance from an array configuration.

<?php

namespace TestsAlwaysIncluded\HealthCheck;

class HealthCheckEvents
{
    /** @const string */
    const EVENT_HEALTH_CHECK_STARTED = 'health.check.start';

    /** @const string */
    const EVENT_HEALTH_CHECK_COMPLETED = 'health.check.completed';

    /** @const string */
    const EVENT_TEST_SUITE_STARTED = 'health.check.suite.start';

    /** @const string */
    const EVENT_TEST_SUITE_COMPLETED = 'health.check.suite.completed';

    /** @const string */
    const EVENT_TEST_GROUP_STARTED = 'health.check.group.start';

    /** @const string */
    const EVENT_TEST_GROUP_COMPLETED = 'health.check.group.completed';

    /** @const string */
    const EVENT_TEST_STARTED = 'health.check.test.start';

    /** @const string */
    const EVENT_TEST_PASSED = 'health.check.test.passed';

    /** @const string */
    const EVENT_TEST_FAILED = 'health.check.test.failed';

    /** @const string */
    const EVENT_TEST_SKIPPED = 'health.check.test.skipped';

    /** @const string */
    const EVENT_TEST_ERROR = 'health.check.test.error'; 

    /** @const string */
    const EVENT_TEST_COMPLETED = 'health.check.test.completed';
}

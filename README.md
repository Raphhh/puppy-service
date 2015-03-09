# Puppy Service

[![Latest Stable Version](https://poser.pugx.org/raphhh/puppy-service/v/stable.svg)](https://packagist.org/packages/raphhh/puppy-service)
[![Build Status](https://travis-ci.org/Raphhh/puppy-service.png)](https://travis-ci.org/Raphhh/puppy-service)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Raphhh/puppy-service/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/puppy-service/)
[![Code Coverage](https://scrutinizer-ci.com/g/Raphhh/puppy-service/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/puppy-service/)
[![Dependency Status](https://www.versioneye.com/user/projects/54062eb9c4c187ff6100006f/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54062eb9c4c187ff6100006f)
[![Total Downloads](https://poser.pugx.org/raphhh/puppy-service/downloads.svg)](https://packagist.org/packages/raphhh/puppy-service)
[![Reference Status](https://www.versioneye.com/php/raphhh:puppy-service/reference_badge.svg?style=flat)](https://www.versioneye.com/php/raphhh:puppy-service/references)
[![License](https://poser.pugx.org/raphhh/puppy-service/license.svg)](https://packagist.org/packages/raphhh/puppy-service)

Basic services for Puppy framework.


## Installation

```
$ composer require raphhh/puppy-service
```

## Session

Service for Symfony\Component\HttpFoundation\Session\Session.


## Template

Service for Twig_Environment.

Note that the services are accessible in twig templates with the global variable "services".

### Config options
 - 'template.directory.main' => path to the directory of the template files.
 - 'template.directory.cache' => path to the directory of the cache of the template files.
 - 'template.debug' => indicates if the debug mode is enable in the template.
 - 'session.sessionStorageClass' => name of the class to handle the session storage.
 - 'session.attributeBagClass' => name of the class to handle the attributes session.
 - 'session.flashBagClass' => name of the class to handle the flash session.

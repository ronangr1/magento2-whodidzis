# Module for Magento 2

[![Latest Stable Version](https://img.shields.io/packagist/v/ronangr1/module-whodidzis.svg?style=flat-square)](https://packagist.org/packages/ronangr1/module-whodidzis)
[![License: MIT](https://img.shields.io/github/license/ronangr1/magento2-whodidzis.svg?style=flat-square)](./LICENSE)
[![Packagist](https://img.shields.io/packagist/dt/ronangr1/module-whodidzis.svg?style=flat-square)](https://packagist.org/packages/ronangr1/module-whodidzis/stats)
[![Packagist](https://img.shields.io/packagist/dm/ronangr1/module-whodidzis.svg?style=flat-square)](https://packagist.org/packages/ronangr1/module-whodidzis/stats)

This module automatically logs every action that creates, updates, or deletes entities in Magento 2—whether triggered by admins, APIs, or automated processes. Gain full visibility into your store’s data changes with a searchable, filterable audit trail that tracks:

✅ What changed (entity type: products, orders, customers, CMS, etc.) <br />
✅ Who made the change (admin user, API, cron job, or system process) <br />
✅ When it happened (timestamp with timezone support) <br />
✅ Change tracking – Records modified fields. <br />

- [Setup](#setup)
    - [Composer installation](#composer-installation)
    - [Setup the module](#setup-the-module)
- [Documentation](#documentation)
- [Support](#support)
- [Authors](#authors)
- [License](#license)

## Setup

Magento 2 Open Source or Commerce edition is required.

###  Composer installation

Run the following composer command:

```
composer require ronangr1/module-whodidzis
```

### Setup the module

Run the following magento command:

```
bin/magento setup:upgrade
```

**If you are in production mode, do not forget to recompile and redeploy the static resources.**

## Documentation

Go to `Store > Configuration > Ronangr1 > WhoDidZis` to enable the feature.

Go to `System > Activity > Records` to see who the fuck changed any values.

## Support

Raise a new [request](https://github.com/ronangr1/magento2-whodidzis/issues) to the issue tracker.

## Authors

- **ronangr1** - *Maintainer* - [![GitHub followers](https://img.shields.io/github/followers/ronangr1.svg?style=social)](https://github.com/ronangr1)
- **Contributors** - *Contributor* - [![GitHub contributors](https://img.shields.io/github/contributors/ronangr1/magento2-whodidzis.svg?style=flat-square)](https://github.com/ronangr1/magento2-whodidzis/graphs/contributors)

## License

This project is licensed under the MIT License - see the [LICENSE](./LICENSE) details.

***That's all folks!***

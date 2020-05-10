[![MIT license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/flarumite/flarum-decontaminator/blob/master/LICENSE.md) [![Latest Stable Version](https://img.shields.io/packagist/v/flarumite/flarum-decontaminator.svg)](https://packagist.org/packages/flarumite/flarum-decontaminator) [![Total Downloads](https://img.shields.io/packagist/dt/flarumite/flarum-decontaminator.svg)](https://packagist.org/packages/flarumite/flarum-decontaminator)

# Decontaminator by Flarumite

- Powerful filtering of user content, using regex
- Integrates with `flarum/flags`
- Match and replace, match and flag or both
- Permissions to override filtering rules
- Supports 'onsave' or 'onload' filtering
- Filters on post content and discussion title

Setup multiple rules to filter any text content automatically. Add a flag alert to bring any rule trigger to the attention of your moderators.

### Screenshots
- Create a new rule:
![Create new rule](https://community.giffgaff.com/assets/files/2020-05-10/1589142694-423593-screenshot-2020-05-10-at-211411.png)

- Show current rules:
![Show all current rules](https://community.giffgaff.com/assets/files/2020-05-10/1589142694-673556-screenshot-2020-05-10-at-212909.png)

- Example of match and replace:
![create a post with content that matches a rule](https://community.giffgaff.com/assets/files/2020-05-10/1589142694-841464-screenshot-2020-05-10-at-213010.png)

Is replaced with:

![Replaced match](https://community.giffgaff.com/assets/files/2020-05-10/1589142694-966709-screenshot-2020-05-10-at-213026.png)

### Installation

Install with composer:

```sh
composer require flarumite/flarum-decontaminator
```

## **Creating a regex rule _may_ have undesired effects. Please be certain you know what your rule is doing**

### Links

- [Packagist](https://packagist.org/packages/flarumite/flarum-decontaminator)
- [GitHub](https://github.com/flarumite/flarum-decontaminator)

# Disable Yoast SEO Redirects #

Disables Yoast SEO Premium's redirection manager, including automatic redirection generation and notifications.


## Description ##

When activated, this plugin does the following:
* Disables automatic generation of redirects when posts/terms are deleted, or when their slugs are modified.
* Disables notifications from Yoast about redirects when posts/terms are deleted, or when their slugs are modified.
* Removes the Redirects submenu page under "SEO" in the WordPress admin.


## Documentation ##

Head over to the [Disable Yoast SEO Redirects wiki](https://github.com/UCF/Disable-Yoast-SEO-Redirects/wiki) for detailed information about this plugin and installation instructions.


## Changelog ##

### 1.0.0 ###
* Initial release


## Upgrade Notice ##

n/a


## Development ##

[Enabling debug mode](https://codex.wordpress.org/Debugging_in_WordPress) in your `wp-config.php` file is recommended during development to help catch warnings and bugs.

### Requirements ###
* node
* gulp-cli

### Instructions ###
1. Clone the Disable-Yoast-SEO-Redirects repo into your local development environment, within your WordPress installation's `plugins/` directory: `git clone https://github.com/UCF/Disable-Yoast-SEO-Redirects.git`
2. `cd` into the new Disable-Yoast-SEO-Redirects directory, and run `npm install` to install required packages for development into `node_modules/` within the repo
3. Optional: If you'd like to enable [BrowserSync](https://browsersync.io) for local development, or make other changes to this project's default gulp configuration, copy `gulp-config.template.json`, make any desired changes, and save as `gulp-config.json`.

    To enable BrowserSync, set `sync` to `true` and assign `syncTarget` the base URL of a site on your local WordPress instance that will use this plugin, such as `http://localhost/wordpress/my-site/`.  Your `syncTarget` value will vary depending on your local host setup.

    The full list of modifiable config values can be viewed in `gulpfile.js` (see `config` variable).
4. If you haven't already done so, create a new WordPress site on your development environment to test this plugin against, and install and activate Yoast SEO Premium.
5. Activate this plugin on your development WordPress site.
6. If you enabled BrowserSync in `gulp-config.json`, you can run `gulp watch` to continuously watch changes to PHP files in this project and reload your browser when those files change.

### Other Notes ###
* This plugin's README.md file is automatically generated. Please only make modifications to the README.txt file, and make sure the `gulp readme` command has been run before committing README changes.  See the [contributing guidelines](https://github.com/UCF/Disable-Yoast-SEO-Redirects/blob/master/CONTRIBUTING.md) for more information.


## Contributing ##

Want to submit a bug report or feature request?  Check out our [contributing guidelines](https://github.com/UCF/Disable-Yoast-SEO-Redirects/blob/master/CONTRIBUTING.md) for more information.  We'd love to hear from you!

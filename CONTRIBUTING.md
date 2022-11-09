# Salex Contribution Guide

**BUGS:**

Thank you for your interest to work on this project with us. Please refer to http://devdocs.bagisto.com for documentation on how to use library features properly. Modular, well encapsulated code will be much appreciated while contributing to the project.


**Which branch you should target?**

All bug fixes should be sent to the latest staging branch, i.e. development branch. Bug fixes should never be sent to the master branch unless they fix features that exist only in the upcoming release.

Minor features fully backwards compatible with the current Laravel release may be sent to the latest stable branch.

Major new features should always be sent to the master branch, which contains the upcoming Bagisto release.

**Compiling assets:**

If you are submitting a change that will affect a compiled file, such as most of the files in admin/resources/assets/sass or admin/resources/assets/js of the Bagisto repository, do not commit the compiled files. Due to their large size, they cannot realistically be reviewed by a maintainer. This could be exploited as a way to inject malicious code into Bagisto. To defensively prevent this, all compiled files will be generated and committed by Bagisto maintainers.

**Theme Editing(Succinct):**

When working on theme files, it is recommended to edit the sass files directly instead of the compiled css files. the sass files can be found in the packages/Salex/Succinct/src/Resources/assets/sass there are different scss files for different pages.

After editing the sass files, you will have to compile by running in the same folder (packages/Salex/Succinct/src)
you may need to run cd packages/Salex/Succinct/src to change terminal to that directory

  ``` script

    npm run prod

  ```
and then to publish the files to the UI

  ``` terminal

    php artisan vendor:publish --all --force

  ```

I recommend the proper css styles and targets should be experimented within chrome and then the .scss files should worked on to avoid running these scripts to much as it may take some seconds to complete.

All changes for the theme cohesion should be made within the scss and resource files of the theme, making changes in other folder will affect other files and may have unexpected consequences.


**Code style:**

Bagisto follows PSR-2 for coding standards and PSR-4 as of Laravel for autoloading standards.

**PHPDoc:**

Below is an example of a valid Bagisto doc block. Note that the @param attribute is followed by two spaces, the argument type, two more spaces, and finally, the variable name:
  ``` php
    /**
    * Register a service with CoreServiceProvider.
    *
    * @param  string|array  $loader
    * @param  \Closure|string|null  $concrete
    * @param  bool  $shared
    * @return void
    * @throws \Exception
    */
    protected function registerFacades($loader, $concrete = null, $shared = false)
    {
        //
    }
  ```

**Code style:**

## Tasks to be completed

Tracking order page on shop
Batching of Shipments algorighm for admin to create a batch of shipments and assign to driver
Theming
Payment Platform integration
Geolocation codes
Order flagging
Cabinet integration
Security
Map
Shipment Dates implementation
Homepage Changes
Status controls
Product creation
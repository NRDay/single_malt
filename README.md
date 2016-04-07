# Single Malt

A theme based on _S for a Gulp workflow. Includes Bourbon and Neat.
## Installation

1. Install [Node.JS](https://nodejs.org/en/) and [Gulp](https://github.com/gulpjs/gulp/blob/master/docs/getting-started.md).

2. Install the Theme as normal.

3. Navigate to the app folder and run:

  ```bash
  $ npm install
  ```

4. On line 17 of gulpfile.js change the proxy location to the root of your site.

5. You can now run 

  ```
  gulp
  ```

from terminal.

## Dev Mode

At the top of functions.php you will see

  ```php
  if (! defined('DEV_MODE')) {
	define( 'DEV_MODE', true );
  }
  ```

This enables DEV mode, when enabled your scripts and styles will be enqueued normally. When you are ready to deploy, set this to "false" and then run 

  ```
  gulp build
  ```

Now, only the merged and minified files will be enqueued.

##Build something awesome, then go to pub with your mates for a pint and whisky chaser. :)







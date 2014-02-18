# sgd Sculpin Github Deploy
### Description
sgd is a phar package to automate sculpin and git tasks all without leaving the root sculpin directory.
## ALPHA release version 0.0.1
This package is in early ALPHA release stage.

I urge you to make a test repo, test remote repo, and test sculpin blog to try this out with until you feel comfortable that it works well and is not going to corrupt or destroy your real sculpin blog.

Even then I would strongly advise keeping a backup copy and be familiar with rolling back git commits.

There is an issue when a remote repository already exists. You will need to manually merge upstream changes before first time use of sculpin:copy or any other sgd git commands, otherwise you will get an error like this
```
 ! [rejected]        master -> master (non-fast-forward)
error: failed to push some refs to 'git@github.com:isimmons/foo.git'
hint: Updates were rejected because the tip of your current branch is behind
hint: its remote counterpart. Merge the remote changes (e.g. 'git pull')
hint: before pushing again.
hint: See the 'Note about fast-forwards' in 'git push --help' for details.
```
To avoid this manually run 
```
git pull origin master
```
And then check the status to make sure everything is ok before continuing to use sgd.

I will be adding basic fetch pull and merge commands very soon.

Feel free to tinker around, test, and even contribute if you wish.

## TODO
* More testing
* More error handling
* More safety checks (don't want to hose anyones files)
* More commands (fetch, pull, merge in the works)
* Work on making commands easier and more intuitive
* Fix some incorrect docblocks
* Plan to implement some type of config file to avoid repo as a required argument to every command

## Why use it?
You could initialize a git repository inside the sculpin build directory but there is a risk of it being overwritten and you would still have to cd back and forth between the sculpin root and the build directory when switching between editing or building your site and running git commands to push changes.

Or you can create a git repository outside the sculpin directory but you still need to change back and forth between editing your blog/site and working in the git repository to get those changes pushed up to your github account.

With sgd you can cd into the sculpin directory once and perform all tasks from there. No changing directories and no switching cli windows or tabs is required.

There may be other ways to do this but I think a simple deploy script makes things easy and this is a starting off point. I fully intend on adding more features/commands and improving on existing ones as fast as possible.

## Installation
Download [sgd.phar](https://github.com/isimmons/sgd/raw/master/sgd.phar) and place it in the root of your Sculpin directory or make it global by placing it in /usr/local/bin. Windows users can place it in any directory on the system PATH. I recommend having a single 'bin' directory for things like this somewhere like C:\bin or C:\usr\bin to somewhat mimic the Mac/Linux way.

Windows users can also add a bat file for convenience because calling a phar file directly requires the full path and extension. Drop this bat file in beside sgd.phar whether in the sculpin directory or in another directory on the system PATH. I know Windows just makes things difficult.
###### sgd.bat
```
@echo off
php sgd.phar %*
```

If you would like to develope and compile your own you can clone this repo and then build a new sgd.phar using the `box build` command (requires kherge/Box installed on your system).


## How it works
See documentation at [docs/main.md](https://github.com/isimmons/sgd/tree/master/docs/main.md) for a listing of all available commands, their usage, and an example deployment workflow.

## Testing
I have created some directories and files and a initialized but empty git repository inside tests/resources to test the GitRunner and SculpinCopier classes.

I'm not sure yet of the potential dangers of this but it makes me uneasy having tests create and delete files and directories. If you view the tests (GitRunnerTest.php and SculpinCopierTest.php) notice the tearDown methods. In each test there is a tearDown that calls $this->cleanResourcesDir(); This is the part that concerns me. For this reason, even though I have run the tests extensively on my own system, I have marked them to be skipped in the setUp methods. This way individual developers can decide if they want to enable these tests.

## Credits
Author: Ian Simmons

Email: [isimmons33@gmail.com](mailto:isimmons33@gmail.com)

Twitter: [@isimmons](https://twitter.com/isimmons33)

Website: [isimmons.github.io](http://isimmons.github.io)

#####Helpful projects I learned from in making sgd:
###### Symfony commands and phar files
[Laravel/Envoy](https://github.com/laravel/envoy)
###### Running git commands from PHP
[Git.php](https://github.com/kbjr/Git.php)
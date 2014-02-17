# SGD (Sculpin Github Deploy)

## Documentation

### What is sgd?

sgd is a self contained phar providing several commands which make publishing Sculpin generated static content to a github repository easy. With sgd you can stay in your sculpin directory and not only copy the sculpin output directory to a local repo anywhere on your computer, but you can also run the necessary git commands to add, commit, and push that repo without having to do all that manual switching back and forth between directories.

### Commands Provided by sgd
###### `sculpin:copy` Copies files and directories from a source directory to a destination directory.
```
    Usage:
    
    sculpin:copy src dest
     
    Aguments:
    src                   Path to sculpin build directory (Required)
    dest                  Path to target repository (Required)
```
###### `repo:add`      Runs the git add command on the given repository.
```
    Usage:
     repo:add [--files[="..."]] repo [file]

    Arguments:
     repo                  Path to target repository (Required)
     file                  Add individual file (default: ".")

    Options: Option --files not implemented yet
     --files               Add multiple files. Defaults to "." (default: ".")
```
###### `repo:commit` Runs git commit on the given repository.
```
    Usage:
     repo:commit repo [message]

    Arguments:
     repo                  Path to target repository (Required)
     message               Commit message (default: "New Post")
```
###### `repo:push`     Runs git push on the given repository.
```
    Usage:
     repo:push repo [remote] [branch]

    Arguments:
     repo                  Path to target local repository (Required)
     remote                Remote repository (default: "origin")
     branch                Local branch to push (default: "master")
```
###### `repo:status` Runs git status on the given repository.
```
    Usage:
     repo:status repo

    Arguments:
     repo                  Path to target repository (Required)
```
###### `repo:validate` Checks to see if a given directory is a valid git repository.
```
    Usage:
     repo:validate repo

    Arguments:
     repo                  Path to target repository (Required)
```

### Installation
Download the latest sgd.phar from here.

Place it in the root of your Sculpin blog.

Manually create the repository where you wish to deploy sculpin to. At the moment `repo:remote` has not been implimented so sgd will not be able to push until you have added the remote to your repository.

Once you have a working repository with upstream remote like username.github.io added you can start easily deploying new posts following the workflow below.

### Workflow
Assuming your (mygithubrepo) and your sculpin directories are set up and ready to go and you have prepared a nice blog post following the exellent instructions here https://sculpin.io/getstarted/ You're satisfied with it and ready to deploy.

1. `sculpin generate --env=prod` (if you haven't already done this)
2. `sgd sculpin:copy output_prod path/to/your/repo`
You should see a success message like 'Files successfully copied from output_prod to path/to/your/repo.'
3. `sgd repo:add`
You should see a success message like 'Files successfully added. Ready for commit.'
4. `sgd repo:commit`
You should see a success message like 'Files successfully commited. Ready to push.'
5. `sgd repo:push`
You should see a success message like 'Files successfully pushed to the remote repository.'

Now go to Github and refresh your repository or visit your username.github.io and see the new changes.

It's super easy. Remember if you have problems or need more information about your repository you can use the additional status and validate commands. The ability to add a remote via sgd will be added soon and then you will be able to create and prepare your repository from the root of your sculpin site too.

---
title: 'git commands i did not know'
taxonomy:
    tag:
        - GIT
date: '2025-03-11'
---

I read about some interesting git commands that I don't know.

## Local test environment

For testing I like to use a local 'remote' repository

- create a directory 'remote-repo'
- navigate on the command line in this directory
- initialize the repository ```git init```
- create a master branch ```git checkout -b master``''
- to use it as 'remote' repo, open the file '.git/config' and append the follow lines
  ```
  [receive]
	denyCurrentBranch = ignore
  ```
  Otherwise, you get an error when you try to push something in the repo

- create a directory 'local-repo'
- navigate on the command line in this directory
- initialize the repository ```git init```
- create a file 'text1.txt' 
- add the file to the stage ```git add --all```
- commit the changes ```git commit -m "[ADD] test1.txt"```
- add the remote repository ```git remote add origin ../remote-repo/.git```
- push the commit in the remote repository ```git push --set-upstream origin master```

## Clean Untracked Files and Directories


```git reset --hard``` reset local changes, but not remove untracked files.

```git clean -fd``` remove all untracked files. It not removes ignored files.

## Append changes to the last commit

- Do same change, e.g. ```touch test2.txt```
- add changes to stage ```git add --all```
- append to last commit and change the message ```git commit --amend -m "new message"```
- also useful to change submit message without change some files
- when the last commit is always been pushed then use ```git push --force``` to push the changes in the remote repo, because you changed the history
  - be careful and use this only in feature brunches where you work alone.

## Links

- [20-git-command-line-tricks](https://dev.to/jagroop2001/20-git-command-line-tricks-every-developer-should-know-1i21)
- [git-clean](https://git-scm.com/docs/git-clean)
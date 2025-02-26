---
title: 'Git Flow'
taxonomy:
    tag:
        - git
date: '2024-10-22'
---

One of my topics today was git workflows.    
I read something about git flow and the github flow.

In the past I always work with a develop and a master brunch.
After I read about github flow, I was wondering why I always use develop branches:-)

For my customers workflow, I decide to use github flow with release branches.
With release brunches it is possible to ship single features from develop branch to the release branch,
without the need to create a new release.
I know that this is a little dirty, but the customer have little features sometimes, which he wants to have on the production system without a new release of all other features they are already developed and merged. So I can cherrypick this comments to the actual release.

<pre>
Feature  x__x               x     x
        /   \              /\    /\
Master x-----x----------x----x-----x---
                \    \ /      \       \
Hotfix           \    x        \       \
                  \    \        \       \
Release            x----x--------x       x
</pre>

## Helpful git commands

pick a single commit from another branch and execute them on the current branch    
```git cherrypick [commit-id]```

Set branch pointer to a specific commit.    
```git branch -f <branchname> <commit-id>```

## Links

- [Git Flow vs GitHub Flow](https://www.alexhyett.com/git-flow-github-flow/)
- [Gitflow workflow](https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow)
- [How do I make a branch point at a specific commit?](https://stackoverflow.com/questions/7310177/how-do-i-make-a-branch-point-at-a-specific-commit)


## Links for CI/CD

- [CI/CD pipelines on Gitlab](https://docs.gitlab.com/ee/ci/pipelines/)
- [A gitlab-ci config to deploy to your server via ssh](https://medium.com/@hfally/a-gitlab-ci-config-to-deploy-to-your-server-via-ssh-43bf3cf93775)
- [Run your GitHub Actions locally](https://github.com/nektos/act)
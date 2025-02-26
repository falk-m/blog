---
title: 'summarize git commits'
taxonomy:
    tag:
        - git
date: '2024-10-23'
---

In some cases there is a feature branch with many commits and you want to replace all this small commits with one big commit.

**1. check if everithing is committed.**

You have to have no local changes.

**2. reset the last x commits**

```git reset --soft HEAD~2```

This remove the last 2 commits and make the changes in ýour local environment 'uncommitted'.

**3. create a new commit** 

```git commit -m "new commit message"```

**4. push the new commit to the repository**

```git push --force```


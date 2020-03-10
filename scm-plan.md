# SCM Plan
## Guidelines
The team shall abide by the guidelines for the following SCM activities.

## Commit
* In general, provide a commit message summary that finishes the sentence:

> If applied, this commit will…

* Add a commit message body if required to add additional context using hyphens (-).
* Before committing, run tests locally.

## Merge Branch
* Before merging branches, submit a pull request for which the team can review all additions.

## Push
* To reduce the likelihood of conflicts:
 * always sync changes (by running `git fetch` and `git pull`) before pushing code.
 * freeze the repository by not allowing other team members to push at the same time.
* When conflicts arise, the team members working on the same part of the project must discuss whether to accept the current or incoming change.
* Once a commit has been pushed, review the tests running on Travis CI.
 * If the tests fail, look for a solution.
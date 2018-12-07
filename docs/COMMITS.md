## Commit Message Format

`<type>(<scope>): <subject>`

## Type
Must be one of the following:

* build: Changes that affect the build system or external dependencies (example scopes: gulp, broccoli, npm)
* ci: Changes to our CI configuration files and scripts (example scopes: Travis, Circle, BrowserStack, SauceLabs)
* docs: Documentation only changes
* feat: A new feature
* fix: A bug fix
* perf: A code change that improves performance
* refactor: A code change that neither fixes a bug nor adds a feature
* style: Changes that do not affect the meaning of the code (white-space, formatting, missing semi-colons, etc)
* test: Adding missing tests or correcting existing tests

## Scope

The scope could be anything specifying place of the commit change. For example User, UserService, auth, etc...

You can use * when the change affects more than a single scope.

## Subject

The subject contains succinct description of the change:

use the imperative, present tense: "change" not "changed" nor "changes"
don't capitalize first letter
no dot (.) at the end

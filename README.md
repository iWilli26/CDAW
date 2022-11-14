# Template project for CDAW

## Prerequisites

- git - https://git-scm.com/downloads
- docker - https://docs.docker.com/get-docker/
- vscode - https://code.visualstudio.com/
- vscode remote container extension - https://code.visualstudio.com/docs/remote/containers
- create a github account

## How to use this template?

1. go to https://github.com/ceri-num/uv-cdaw-template
2. click on the green button "use this template". This will create a similar git repository on your account
3. clone your repository on your machine

```
git clone https://github.com/xxxx/uv-cdaw-template MyCDAWProject
```
4. Open the project with VSCode and re-open it with remote container extesion (the 1st launch takes time)

You should have:
- Apache on http://localhost:5080
- PhpMyAdmin on http://localhost:5081
    2 mysql accounts: root/root and mysql/mysql

Simple ``it works`` test: http://localhost:5080/test-pdo/test-PDO.php

xdebug is installed so you can put breakpoints in your code.

# Others links

- https://www.section.io/engineering-education/dockerized-php-apache-and-mysql-container-development-environment/

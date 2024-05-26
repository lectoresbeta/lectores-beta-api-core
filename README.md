<table align="center">
    <tr style="text-align: center;">
        <td align="center" width="9999">
            <img src="./.etc/logo.png" width="200" alt="Project icon" style="margin:0; padding: 0; display: inline-block">

<h1 style="margin: 0; padding: 0; color: black;">Lectores Beta - Core API</h1>
</td>
</tr>
</table>

# Setup :gear:

## 1. Install Dependencies :hammer:

```shell
make start
```

## 2. Discover another useful commands :mag_right:

```shell
make show-containers   List all our active containers
make start             Start and run project
make start/force       Start and run project forcing container contextual rebuild
make stop              Stop project
make install           Install dependencies
make package/add       Install new package through composer
make bash              Enter to the php-fpm container
make unit              Run unitary tests suite
make style/all         Analyse code style and possible errors
make style/code-style  Analyse code style
make style/fix         Fix code style
```

# Project structure :file_folder:

Below you'll encounter a **explainful** directory structure explained item by item its role,
utility and which kind of file or code it's expected in that place.

```text
.
├── config              # Framework configuration centralized point
│   ├── modules.yaml    # Centralized point to register module config
│   ├── packages        # Third party packages configuration
│   ├── routes.yaml     # Centralized point to register routes from each module
│   └── services.yaml   # Centralized symfony container
├── docker-compose.dist.yaml    # Distributable version of docker compose
├── docker-compose.yaml         # Executable version of docker compose
├── grumphp.yaml                # Tooling to handle coding standards in the repo
├── phpstan.dist.neon           # Distributable version of PHPStan config
├── phpstan.neon                # Executable version of PHPStan config
├── .php-cs-fixer.dis.php       # Distributable version of phpcsfixer config
├── .php-cs-fixer.php           # Executable version of phpcsfixer config
├── phpunit.xml                 # Distributable version of PHPUnit config
├── phpunit.xml.dist            # Executable version of PHPUnit config
├── src                         # Application source per module
│   ├── Kernel.php              # Application shared kernel
│   ├── Packages                # Boilerplate code from third party / libraries
│   ├── Module                  # Layered application modules
│   │   └── User
│   │       ├── Domain
│   │       ├── Application
│   │       └── Infrastructure
│   └── Shared                  # Layered application shared module
│       └── Infrastructure
│           └── Doctrine
└── tests                       # Centralized container of testing for each module
    └── bootstrap.php

```

# Working agreements :handshake: :raised_hands:

### Team :people_holding_hands:

1. Help each other
2. Convince, do not impose
3. Common sense
4. Be aware about the tooling that we have in the project
5. Find solutions, not the guilty ones
6. Bring with proposals before asking for help :pray:

### Code :computer:

1. Boyscout rule (leave your code better than you found it).
2. Testing culture, the more, the better.
3. Reuse code. (It doesn't means apply **DRY** without any sense).
4. Do not use **deprecated** library versions always LTS or enough maintained.
5. Every single change must be under PR even a hotfix or a revert commit

### Pull requests :octocat:

1. Small PR's **the smaller, the better** (max. 35 files).
2. PR's always in sync with the target branch
3. 1 PR === 1 commit :pray:
4. **The most clear the PR explanation**, the better.
5. Each PR must be approved at least for one mate through a comment `APPROVED :heavy_check_mark:`
6. As soon as PR get approve, it should be merged and deployed.
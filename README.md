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
utility and which kind of file or code it's expected on that place.

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

```text
To be defined
```
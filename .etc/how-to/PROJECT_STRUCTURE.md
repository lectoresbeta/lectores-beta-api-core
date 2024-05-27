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
├── migrations                  # Database migrations folder grouped by year
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
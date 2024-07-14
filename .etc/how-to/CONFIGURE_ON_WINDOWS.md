# Configure on windows :windows_conf:

## Description

Instructions to configure and run the project in a local environment with Windows.
## Prerequisites

- Ubuntu installed.
- Docker Desktop for Windows, with WSL 2 enabled.
- `make` installed on Ubuntu, run in the Ubuntu terminal:
```
sudo apt update
sudo apt install make
```


## Initial Setup

### Configure Docker with WSL 2 for Ubuntu
**Enable WSL 2 and Configure Docker Desktop**:
   - In Docker Desktop, go to `Settings > General` and make sure `Use the WSL 2 based engine` is enabled.
   - In `Settings > Resources > WSL Integration`, activate the integration with your Ubuntu distribution.
   - Apply the changes and restart Docker Desktop.


### Prepare the Project and get it up locally.
Once you have opened the terminal in the project directory with ubuntu, you should follow these steps:
1. **Raise Docker container**:
```
docker-compose up -d
```
2. **Install dependencies in the container**: ``` docker-compose up -d ```.
```
docker-compose exec webserver composer install
```

3. **Execute DB migrations** ``` docker-compose exec webserver composer install ``` 3.
```
make migrations
```

### Access the index

Now we should have our local environment running by accessing via our browser at: localhost::9000

# 1. Make sure Docker is pointing to Minikube

eval $(minikube -p minikube docker-env)

# 2. Rebuild the image explicitly without BuildKit

DOCKER_BUILDKIT=0 docker build -t devops-laravel:latest .

# 3. Verify it exists inside Minikube's Docker

docker images

# 4. Deploy in Kubernetes

kubectl delete pod -l app=laravel
kubectl get pods -w

# Option:

- Only run Web App using Docker Image (ViewOnly, tanpa source code):
    - Repository: `https://github.com/221110019/CatCanine-ViewOnly.git`
- With Project Source Code + using Laravel Sail to integrate with Docker
    - Repository: `https://github.com/221110019/CatCanine-full.git`

# Requirement (Window)

- Docker Desktop running with WSL2 integration enabled
- WSL2 engine (sebaiknya Ubuntu)
- Sebaiknya run command dengan terminal Ubuntu (bukan Powershell etc), performa lebih cepat

# [OPTION 1] Docker Image, no source code

- Harus Install Docker Desktop dan WSL2 (disarankan Ubuntu)
- Docker Desktop with WSL2 engine integration enabled pada setting
- Buka terminal Ubuntu
- (opsional) cd ke path folder

```bash
git clone https://github.com/221110019/CatCanine-ViewOnly.git
```

- cd ke folder clone
- Pull build image terbaru dari Docker Hub

```bash
docker compose pull
```

- Start

```bash
docker compose up
atau
docker compose up -d
```

- Akses web app di http://localhost

- Stop

```bash
docker compose stop
```

- Stop and remove container

```bash
docker compose down
```

- Remove all container, volume, and image

```bash
docker container prune -f
docker volume prune -a -f
docker system prune -a -f
```

# [OPTION 2] Laravel Sail, with source code

- Locate ke path folder

```bash
git clone https://github.com/221110019/CatCanine-full.git
```

- cd ke folder clone

```bash
cp .env.example .env
```

- install composer

```bash
docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v $(pwd):/var/www/html \
  -w /var/www/html \
  laravelsail/php82-composer:latest \
  composer install
```

- (opsional agar memudahkan run command `./vendor/bin/sail`), jadi tinggal ganti `./vendor/bin/sail` menjadi `sail`

```bash
echo "alias sail='bash vendor/bin/sail'" >> ~/.bashrc
source ~/.bashrc
```

- Start sail

```bash
./vendor/bin/sail up -d
# or with alias
sail up -d
```

- Access app at http://localhost
- Build front-end, Sail harus running

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

- Database Migration, Sail harus running

```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
./vendor/bin/sail artisan storage:link
```

# CI/CD

> Triggered by push to master

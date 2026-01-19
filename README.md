# Required Tools

- Ubuntu
- Docker
- kubectl
- minikube:
    - addons metrics-server

---

# 1. Image dari Docker Hub / CI-CD

Clone GitHub

```bash
git clone https://github.com/221110019/CatCanine-full.git
cd CatCanine-full

```

Start Minikube

```bash
minikube start --driver=docker
minikube dashboard &
```

Pull Latest Image

```bash
docker pull 221110019/devops-laravel:latest
```

Apply Kubernetes Resources

```bash
kubectl apply -f kubernetes/
kubectl get pods -w
```

Access APP URL

```bash
minikube service laravel --url
```

# 2. Build Image Local

Start Minikube

```bash
minikube start --driver=docker
minikube status
```

Build Docker Image

```bash
eval $(minikube docker-env)
DOCKER_BUILDKIT=0 docker build -t devops-laravel:latest .
docker images
```

Apply Kubernetes

```bash
kubectl apply -f kubernetes/
kubectl get pods -w
kubectl get svc
kubectl logs -f <pod_name>

```

APP URL

```bash
minikube service laravel --url
#atau
kubectl port-forward service/laravel 8080:80
```

# 3. HPA

Horizontal Pod Autoscaler (tunggu 1-2 menit) & dashboard

```bash
minikube addons enable metrics-server
minikube addons list
kubectl get hpa -w
kubectl top pods
kubectl top nodes

minikube dashboard &
watch -n 10 "kubectl get pods,hpa && echo --- && kubectl top pods"

```

Close & Reproduce

```bash
kubectl delete -f kubernetes/
minikube delete
minikube start
kubectl apply -f kubernetes/
kubectl get pods -w

```

# Others

Remove Unused Images

```bash
docker image prune -f
```

Pause Minikube (keeps state)

```bash
minikube pause
```

Stop Minikube

```bash
minikube stop
```

Delete everything

```bash
minikube delete
```

Hard reset all

```bash
minikube delete --all --purge
docker system prune -af --volumes
```

# Note

## Horizontal Pod Scaler

- addons metrics-server
- Stress Test: membuat pod baru jika overload (success)
- Perlu tunggu 1-2 menit
- Stress Test `kubectl run test --image=busybox --rm -it -- sh -c 'while true; do curl http://laravel/; sleep 1; done'`

## CI/CD Kubernetes

- cat ~/.kube/config -> KUBE_CONFIG GitHub Secret

## Monitoring Tools

- addons metrics-server (cocok)
- Prometheus+Grafana (heavy)

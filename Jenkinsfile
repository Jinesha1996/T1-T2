name: CI/CD Pipeline

on:
  push:
    branches:
      - main

jobs:
  build:
    runs-on: ubuntu-latest

    steps:
    - name: Checkout code
      uses: actions/checkout@v2

    - name: Set up Docker Buildx
      uses: docker/setup-buildx-action@v1

    - name: Login to DockerHub
      uses: docker/login-action@v1
      with:
        username: ${{ secrets.DOCKER_USERNAME }}
        password: ${{ secrets.DOCKER_PASSWORD }}

    - name: Build and push Docker image
      uses: docker/build-push-action@v2
      with:
        context: .
        push: true
        tags: your-dockerhub-username/php-app:latest

  deploy:
    runs-on: ubuntu-latest
    needs: build

    steps:
    - name: Checkout code
      uses: actions/checkout@v2

    - name: Set up kubectl
      uses: azure/setup-kubectl@v1
      with:
        version: 'v1.19.0'

    - name: Set up Kubeconfig
      run: echo "${{ secrets.KUBECONFIG }}" > $HOME/.kube/config

    - name: Deploy to Kubernetes
      run: |
        kubectl apply -f deployment.yaml
        kubectl apply -f service.yaml

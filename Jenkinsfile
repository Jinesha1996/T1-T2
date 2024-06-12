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

    - name: Set up PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '7.4'

    - name: Install Composer dependencies
      run: composer install

    - name: Run SonarQube Scanner
      env:
        SONAR_HOST_URL: ${{ secrets.SONAR_HOST_URL }}
        SONAR_TOKEN: ${{ secrets.SONAR_TOKEN }}
      run: |
        sonar-scanner \
          -Dsonar.projectKey=my-php-app \
          -Dsonar.sources=. \
          -Dsonar.host.url=${{ secrets.SONAR_HOST_URL }} \
          -Dsonar.login=${{ secrets.SONAR_TOKEN }}

    - name: Log in to Docker Hub
      run: echo "${{ secrets.DOCKER_PASSWORD }}" | docker login -u "${{ secrets.DOCKER_USERNAME }}" --password-stdin

    - name: Build Docker image
      run: docker build -t my-dockerhub-username/colorful-blog:latest .

    - name: Push Docker image to Docker Hub
      run: docker push my-dockerhub-username/colorful-blog:latest

    - name: Set up Kubernetes
      uses: Azure/setup-kubectl@v1
      with:
        kubeconfig: ${{ secrets.KUBECONFIG }}
    
    - name: Deploy to Kubernetes
      run: |
        kubectl apply -f k8s/deployment.yaml
        kubectl apply -f k8s/service.yaml

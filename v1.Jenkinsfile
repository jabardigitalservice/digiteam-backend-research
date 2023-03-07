pipeline {
  agent any
  environment {
      REGISTRY_URL = "${env.REGISTRY_URL}"
      REGISTRY_USERNAME = "${env.DIGITEAM_REGISTRY_USERNAME}"
      REGISTRY_PASSWORD = "${env.DIGITEAM_REGISTRY_PASSWORD}"
      IMAGE_NAME = "${env.DIGITEAM_RESEARCH_IMAGE_NAME}"
      SECRET_REPO = "${env.SECRET_REPO}"
      SECRET_LOCATION = "${env.DIGITEAM_BACKEND_RISET_SECRET_LOCATION}"
  }
  options {
    timeout(time: 1, unit: 'HOURS')
  }
  stages {
    stage('Docker Build') {
      steps{
        dir ('sd-without-library') {
          sh 'docker build -t $IMAGE_NAME-v1:$BUILD_NUMBER -f docker/Dockerfile .'
        }
      }
    }
    stage('Docker Push') {
      steps{
        sh 'docker login -u $REGISTRY_USERNAME -p $REGISTRY_PASSWORD $REGISTRY_URL'
        sh 'docker push $IMAGE_NAME-v1:$BUILD_NUMBER'
      }
    }
    stage('Update Deployment Image') {
      steps {
        sh 'rm -rf jds-config'
        sh 'git clone $SECRET_REPO'
        dir ("$SECRET_LOCATION") {
          sh 'sed -i "s/image:.*/image: $IMAGE_NAME-v1:$BUILD_NUMBER/g" backend-v1/digiteam-api-research-v1.yaml'
          sh 'git checkout -b digiteam-backend-research-v1-$BUILD_NUMBER'
          sh 'git add digiteam-api-research-v1.yaml'
          sh 'git commit -m "Uptade Image Digiteam Backend Research to $BUILD_NUMBER"'
          sh 'git push origin digiteam-backend-research-v1-$BUILD_NUMBER -o merge_request.description="# Overview \n\n - Digiteam Backend Research $BUILD_NUMBER \n\n ## Evidence \n\n - title: Update Digiteam Backend Research Image to $BUILD_NUMBER \n - project: Digiteam \n - participants:  " -o merge_request.create'
        }
        sh 'rm -rf jds-config'
      }
    }
  }
} 
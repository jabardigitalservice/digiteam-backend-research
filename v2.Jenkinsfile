pipeline {
  agent any
  environment {
      REGISTRY_URL = "${env.REGISTRY_URL}"
      REGISTRY_USERNAME = "${env.DIGITEAM_REGISTRY_USERNAME}"
      REGISTRY_PASSWORD = "${env.DIGITEAM_REGISTRY_PASSWORD}"
      IMAGE_NAME = "${env.DIGITEAM_RESEARCH_IMAGE_NAME}"
  }
  options {
    timeout(time: 1, unit: 'HOURS')
  }
  stages {
    stage('Docker Build') {
      steps{
        dir ('v2-sd-with-library') {
          sh 'docker build -t $IMAGE_NAME-v2:$BUILD_NUMBER -f docker/Dockerfile .'
        }
      }
    }
    stage('Docker Push') {
      steps{
        sh 'docker login -u $REGISTRY_USERNAME -p $REGISTRY_PASSWORD $REGISTRY_URL'
        sh 'docker push $IMAGE_NAME-v2:$BUILD_NUMBER'
      }
    }
    stage('Deploy to JabarCloud') {
      steps {
        sh 'ssh -o StrictHostKeyChecking=no $SERVER_USERNAME@$SERVER_HOST "cd digiteam/backend-v2 && \
        sed -i \\"s/image:.*/image: $IMAGE_DEPLOY-v2:$BUILD_NUMBER/g\\" digiteam-api-research-v2.yaml && \
        ./update-config.sh"'
      }
    }
    stage('Update Deployment Image') {
      steps {
        sh 'rm -rf $SECRET_FOLDER'
        sh 'git clone $SECRET_REPO'
        dir ("$SECRET_LOCATION") {
          sh 'sed -i "s/image:.*/image: $IMAGE_DEPLOY-v2:$BUILD_NUMBER/g" backend-v2/digiteam-api-research-v2.yaml'
          sh 'git checkout -b digiteam-backend-research-v2-$BUILD_NUMBER'
          sh 'git config --global user.email "github-action@github.com"'
          sh 'git config --global user.name "Github Action"'
          sh 'git add backend-v2/digiteam-api-research-v2.yaml'
          sh 'git commit -m "Update Image Digiteam Backend Research to $BUILD_NUMBER"'
          sh 'git push origin digiteam-backend-research-v2-$BUILD_NUMBER -o merge_request.description="# Overview \\n\\n - Digiteam Backend Research $BUILD_NUMBER \\n\\n ## Evidence \\n\\n - title: Update Digiteam Backend Research Image to $BUILD_NUMBER \\n - project: Digiteam \\n - participants:  " -o merge_request.create'
        }
        sh 'rm -rf $SECRET_FOLDER'
      }
    }
  }
} 
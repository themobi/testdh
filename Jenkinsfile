pipeline {
    environment {
        PATH = "/bin:/usr/local/bin:/usr/bin"
    }
    agent any
    stages {
        stage ('Pre Clean Up'){
            steps {
                lock('PreCleanUp') {
                    sh ""
                }
            }
        }
        stage ('Build'){
            steps {
                lock('Build') {
                    sh ""
                }
            }
        }
        stage ('Tests'){
            steps {
                lock('Tests') {
                    sh ""
                    // checkstyle pattern: 'build/logs/checkstyle.xml'
                    step([
                        $class: 'CloverPublisher',
                        cloverReportDir: 'build/coverage',
                        cloverReportFileName: 'coverage.xml',
                        healthyTarget: [methodCoverage: 65, conditionalCoverage: 65, statementCoverage: 65],
                        unhealthyTarget: [methodCoverage: 30, conditionalCoverage: 30, statementCoverage: 30],
                        failingTarget: [methodCoverage: 0, conditionalCoverage: 0, statementCoverage: 0]
                    ])
                }
            }
        }
        stage ('Staging'){
            when { branch "release/*" }
            steps {
                //build job: ''
                sh ""
            }
        }
        stage ('Production'){
            when {
                tag ""
            }
            steps {
                sh ""
                //build job: ''
            }
        }
        stage ('Post Clean up'){
            steps {
                lock('PostCleanup') {
                    sh ""
                }
            }
        }
    }
    post {
        success {
            script {
                bitbucketStatusNotify(
                    buildState: 'SUCCESSFUL',
                    credentialsId: ''
                )
            }
        }
        failure {
            script {
                bitbucketStatusNotify(
                    buildState: 'FAILED',
                    credentialsId: ''
                )
            }
        }
    }
}

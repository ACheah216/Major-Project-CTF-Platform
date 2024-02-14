# Major-Project-CTF-Platform
CTF platform for Major Project. 

[Docker image url](https://hub.docker.com/r/x8v13r/ycep-mp-ctf-platform)

## Instructions:
### Running on docker
To pull image from my repo, run and map:
```bash
docker pull x8v13r/ycep-mp-ctf-platform:latest
docker run -p 8080:80 x8v13r/ycep-mp-ctf-platform:latest
```
 To get interactive shell:
```bash
docker ps # Run in new terminal
docker exec -it b777ad0de656 /bin/bash # Replace with b777ad0de656 with actual container id
```
Port 80 inside the container is mapped to port 8080 on the host.<br>
On host, go to firefox, localhost:8080 to access the web service running in the image.

### Pushing to docker:
Raise an issue in GitHub for permission to push the dockerhub repository. 

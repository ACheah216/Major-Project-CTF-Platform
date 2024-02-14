# Major-Project-CTF-Platform
CTF platform for Major Project. 

[Docker image url](https://hub.docker.com/r/x8v13r/ycep-mp-ctf-platform)

```bash
*To pull image from my repo, run and map, get interactive shell*
docker pull x8v13r/ycep-mp-ctf-platform:latest
docker run -p 8080:80 x8v13r/ycep-mp-ctf-platform:latest
Run docker ps in a new terminal and get container id
docker exec -it b777ad0de656 /bin/bash
(Port 80 inside the container is mapped to port 8080 on the host. On host, go to firefox, localhost:8080 to access the web service running in the image)
```
Raise an issue in GitHub to get instructions to push the dockerhub repository. 

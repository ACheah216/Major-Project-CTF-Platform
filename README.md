# Major-Project-CTF-Platform
CTF platform for Major Project. 

[Docker image url](https://hub.docker.com/r/x8v13r/ycep-mp-ctf-platform)

## Instructions 

### To run via docker:
To pull image from repo, run and map:
```bash
docker pull x8v13r/ycep-mp-ctf-platform:latest
docker run -p 8080:80 x8v13r/ycep-mp-ctf-platform:latest
```
Port 80 inside the container is mapped to port 8080 on the host.<br>
On host, go to web browser, type ```localhost:8080``` to access the web service running in the image.

 To get interactive shell:
```bash
docker ps

# Replace b777ad0de656 with actual container id obtained from docker ps
docker exec -it b777ad0de656 /bin/bash
```

### To run via XAMPP installation:
1. Install and start XAMPP
2. Extract folder into xampp/htdocs
3. Enter [http://localhost/](http://localhost/)(whatever you named unzipped folder as) to the address bar of your browser
   

#!/bin/bash
ssh-agent bash -c 'ssh-add ~/.ssh/id_rsa.search; /usr/bin/git pull 2&1'

#!/bin/bash
### Script para manter code-server rodando no Termux/Ubuntu

LOG="$HOME/code-server.log"
PID="$HOME/code-server.pid"

start() {
    if [ -f $PID ] && kill -0 $(cat $PID) 2>/dev/null; then
        echo "code-server já está rodando (PID $(cat $PID))"
        exit 0
    fi
    echo "Iniciando code-server..."
    nohup code-server --bind-addr 0.0.0.0:8080 >> $LOG 2>&1 &
    echo $! > $PID
    echo "code-server iniciado em background (PID $(cat $PID))"
}

stop() {
    if [ -f $PID ]; then
        kill $(cat $PID)
        rm -f $PID
        echo "code-server parado."
    else
        echo "code-server não está rodando."
    fi
}

status() {
    if [ -f $PID ] && kill -0 $(cat $PID) 2>/dev/null; then
        echo "code-server rodando (PID $(cat $PID))"
    else
        echo "code-server parado."
    fi
}

case "$1" in
    start) start ;;
    stop) stop ;;
    restart) stop; sleep 2; start ;;
    status) status ;;
    *) echo "Uso: $0 {start|stop|restart|status}" ;;
esac

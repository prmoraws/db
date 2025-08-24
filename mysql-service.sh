#!/bin/bash
### Script para manter MySQL sempre rodando no Termux/Ubuntu

LOG="$HOME/mysql.log"
PID="$HOME/mysql.pid"

start() {
    if [ -f $PID ] && kill -0 $(cat $PID) 2>/dev/null; then
        echo "MySQL já está rodando (PID $(cat $PID))"
        exit 0
    fi
    echo "Iniciando MySQL..."
    nohup mysqld_safe --user=mysql --datadir=/var/lib/mysql >> $LOG 2>&1 &
    echo $! > $PID
    echo "MySQL iniciado em background (PID $(cat $PID))"
}

stop() {
    if [ -f $PID ]; then
        kill $(cat $PID)
        rm -f $PID
        echo "MySQL parado."
    else
        echo "MySQL não está rodando."
    fi
}

status() {
    if [ -f $PID ] && kill -0 $(cat $PID) 2>/dev/null; then
        echo "MySQL rodando (PID $(cat $PID))"
    else
        echo "MySQL parado."
    fi
}

case "$1" in
    start) start ;;
    stop) stop ;;
    restart) stop; sleep 2; start ;;
    status) status ;;
    *) echo "Uso: $0 {start|stop|restart|status}" ;;
esac

<?php

    $dsn="mysql:host=localhost;charset=utf8;dbname=test02";
    $pdo=new PDO($dsn,"root","");

    session_start();
    
    if(empty($_SESSION['total'])){
        $total=find("total",1);
        $_SESSION['total']=$total['total']+1;
        $total['total']=$total['total']+1;
        save("total",$total);
    }

    function find($table,...$arg){
        global $pdo;

        $sql="select * from $table where ";

        if(is_array($arg[0])){
            foreach($arg[0] as $key => $value){
                $tmp[]=sprintf("`%s` = '%s'",$key,$value);
            }
            $sql=$sql . implode(" && " ,$tmp);
        }else{
            $sql=$sql . " `id` = '".$arg[0]."'";
        }

        return $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }


    function all($table,...$arg){
        global $pdo;

        $sql="select * from $table ";

        if(!empty($arg[0])){
            foreach($arg[0] as $key => $vaule){
                $tmp[]=sprintf("`%s` = '%s'",$key,$value);
            }
            $sql=$sql . " where " . implode(" && ",$tmp);
        }

        if(!empty($arg[1])){
            $sql=$sql . $arg[1];
        }

        return $pdo->query($sql)->fetchAll();

    }


    function nums($table,...$arg){
        global $pdo;

        $sql="select count(*) from $table ";

        if(!empty($arg[0])){
            foreach($arg[0] as $key => $value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
            $sql=$sql . " where " . implode(" && ",$tmp);
        }

        if(!empty($arg[1])){
            $sql=$sql . $arg[1];
        }

        return $pdo->query($sql)->fetchColumn();

    }


    function save($table,$data){
        global $pdo;

        if(!empty($data['id'])){

            foreach($data as $key => $value){
                if($key!="id"){
                    $tmp[]=sprintf("`%s` = '%s'",$key,$value);
                }
            }
            $sql="update $table set ".implode(",",$tmp)." where `id`='".$data['id']."'";

        }else{

            $sql="insert into $table (`".implode("`,`",array_keys($data))."`) value('".implode("','",$data)."')";

        }

        return $pdo->exec($sql);

    }


    function del($table,...$arg){
        global $pdo;

        $sql="delete from $table where ";

        if(is_array($arg[0])){

            foreach($arg[0] as $key => $value){
                $tmp[]=sprintf("`%s` = '%s'",$key,$value);
            }
            $sql=$sql . implode(" && ",$tmp);

        }else{

            $sql=$sql . " `id` = '".$arg[0]."'";

        }

        return $pdo->exec($sql);

    }


    function q($sql){
        global $pdo;

        return $pdo->query($sql)->fetchAll();

    }

    function to($path){

        header("location:".$path);

    }


















?>
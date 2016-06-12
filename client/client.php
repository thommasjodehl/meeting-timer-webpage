<?php
/** @file meeting_timer_client.php
 *
 *  This module connects to the meeting timer
 *  server and requests the current time left
 *  as well as starts, stops and sets the timer.
 *
 *  @date 160518
 *  @author Thommas Wede Jodehl <thommas_jodehl@hotmail.com>
 */

  /**
   * This function outputs a debug message
   * to the browser console.
   *
   * @date 160518
   * @author Thommas Wede Jodehl <thommas_jodehl@hotmail.com>
   */
   function ConsoleDebugOutput($debugmessage)
   {
      echo("<script>console.log('PHP: ".$debugmessage."');</script>"); // Debug message..
   } // End: ConsoleDebugOutput()

  /**
   * This function initializes a socket
   * and connects the socket to a server.
   *
   * @date 160518
   * @author Thommas Wede Jodehl <thommas_jodehl@hotmail.com>
   */
   function InitSocket($address, $port)
   {
      //Create socket
      if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0)))
      {
         $errorcode = socket_last_error();
         $errormsg = socket_strerror($errorcode);

         die("Could not create socket: [$errorcode] $errormsg \n");
         ConsoleDebugOutput("FAILURE! Could not create socket..");
      }

      ConsoleDebugOutput("Socket created..");

      //Connect to the server
      if(!socket_connect($sock, $address, $port))
      {
         $errorcode = socket_last_error();
         $errormsg = socket_strerror($errorcode);

         die("Could not connect: [$errorcode] $errormsg \n");
      }

      ConsoleDebugOutput("Connection established..");

      return $sock;

   } // End: InitSocket()

  /**
   * This function sends a passed message.
   *
   * @date 160518
   * @author Thommas Wede Jodehl <thommas_jodehl@hotmail.com>
   */
   function SendMessage($socket, $message)
   {
      //Send the message to the server
      if(! socket_send($socket, $message, strlen($message), 0))
      {
         $errorcode = socket_last_error();
         $errormsg = socket_strerror($errorcode);

         die("Could not send the message: [$errorcode] $errormsg \n");
         ConsoleDebugOutput("FAILURE! Could not send the message..");
      }

      ConsoleDebugOutput("Message sent succesfully..");

   } // End: SendMessage()

  /**
   * This function receives a message.
   *
   * @date 160518
   * @author Thommas Wede Jodehl <thommas_jodehl@hotmail.com>
   */
   function ReceiveMessage($socket)
   {
      //Receive answer from the server
      if(socket_recv($socket, $buf, 2045, MSG_WAITALL) === FALSE)
      {
         $errorcode = socket_last_error();
         $errormsg = socket_strerror($errorcode);

         die("Could not receive an answer: [$errorcode] $errormsg \n");
         ConsoleDebugOutput("FAILURE! Could not receive an answer..");
      }

      //Output the received message in the console
      ConsoleDebugOutput($buf);

   } // End: ReceiveMessage()

  /**
   * This function receives a message.
   *
   * @date 160518
   * @author Thommas Wede Jodehl <thommas_jodehl@hotmail.com>
   */
   function CloseSocket($socket)
   {
      //Close the socket
      socket_close($socket);
      ConsoleDebugOutput("Socket closed..");
   } // End: CloseSocket()

   //Main loop
   $socket = InitSocket('localhost', 8888);
   SendMessage($socket, "Hello Server!\n");
   ReceiveMessage($socket);
   CloseSocket($socket);

?>

#include <stdio.h>

void main()
{
  char* shell = (char *) getenv("MYSHELL");
  if (shell)
    printf("%x\n", (unsigned int)shell);
}


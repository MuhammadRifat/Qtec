#include<stdio.h>
#include<string.h>

int main()
{
    char str[1000], word[100];
    int i, j, counter = 0, flag, temp;

    printf("Enter text: ");
    fgets(str, sizeof(str), stdin);

    printf("Enter pattern: ");
    fgets(word, sizeof(word), stdin);

    int lenS = strlen(str) - 1;
    int lenW = strlen(word) - 1;

    for(i = 0; i < lenS; i++)
    {
        if(str[i] == word[0])
        {
            flag = 1;
            temp = i;
            for(j = 1; j < lenW; j++)
            {
                if(str[++temp] != word[j])
                {
                    flag = 0;
                    break;
                }
            }
            if(flag == 1) counter++;
        }
    }

    printf("\n%d times\n", counter);

    return 0;
}

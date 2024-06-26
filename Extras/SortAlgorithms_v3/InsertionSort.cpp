#include <iostream>
#include "Functions.h"

void InsertionSort(long vet[], long size)
{
    long value;
    long j;
    /*
    while (i < size)
    {
        value = vet[i];
        j = i - 1;
        while (j >=0 && vet[j] > value)
        {
            vet[j+1] = vet[j];
            j--;
        }
        vet[j+1] = value;
        i++
    }
    */
    for (long i=1; i < size; i++)
    {
        for (j = i - 1, value = vet[i]; j >= 0 && vet[j] > value; j--)
        {
#ifdef _DEBUG_
            show_color(vet, size,j, j+1);
#endif // _DEBUG_
            vet[j+1] = vet[j];
#ifdef _DEBUG_
            show_color(vet, size,0,0);
#endif // _DEBUG_

        }
        vet[j+1] = value;
#ifdef _DEBUG_
        //std::cout << std::endl;
        //show_color(vet, size,0,0);
        //std::cout << std::endl;
#endif // _DEBUG_
    }
}


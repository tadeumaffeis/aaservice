#include <iostream>
#include "Functions.h"

long left(long i)
{
    return (i * 2) +1 ;
}

long right(long i)
{
    return (i * 2) + 2;
}

long floor(long hs)
{
    long middle = (hs / 2);

    return middle < 0 ? 0 : middle - 1;
}

void heapfy(long  vet[ ], long heapsize, long i)
{
    int l, r, largest;

    l = left(i);
    r = right(i);

    if ((l <= heapsize) && (vet[l] > vet[i]))
        largest = l;
    else
        largest = i;

    if ((r <= heapsize) && (vet[r] > vet[largest]))
        largest = r;

    if (largest != i)
    {
#ifdef _DEBUG_
        show_color(vet, 10, i, largest);
#endif // _DEBUG_

        swap(vet, i, largest);
        heapfy(vet, heapsize, largest);
    }

    return;
}

void buildheap (long vet[], long heapsize)
{
    int i;
    for (i = floor(heapsize); i >= 0; i--)
    {
        heapfy(vet, heapsize - 1, i);
    }
}

void HeapSort(long vet[], long heapsize)
{
    buildheap(vet, heapsize);
    for (long i = heapsize - 1; i >= 0; i--)
    {
#ifdef _DEBUG_
    show_color(vet, 10, 0, i);
#endif // _DEBUG_
        swap(vet, 0, i);
#ifdef _DEBUG_
    std::cout << std::endl;
#endif // _DEBUG_

        heapsize--;
        buildheap(vet, heapsize);
    }
}



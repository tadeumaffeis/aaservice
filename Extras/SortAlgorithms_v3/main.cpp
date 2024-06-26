#include <iostream>
#include "Functions.h"

#define _MINMAXSORT_

void reloadValues(long vet[], long values[], long size)
{
    for (int i=0; i < size; i++)
    {
        vet[i] = values[i];
    }
}

int main(void)
{
    long qtt = 10;
    //long values[] = {1023,776,123,7865,182,14,921,333,471,47};
    long values[] = {10,9,8,7,6,5,4,3,2,1};

#ifdef _DEBUG_
    long vet[15] = {90,87,14,7,12,45,88,90,91,17,8,88,89,101,57};
    long index[] = { 0,1,2,3,4,5,6,7,8,9, 10, 11, 12,13, 14 };


    show_color(index, 15, 0, 0);
    show_color(vet, 15, 0, 0);
    std::cout << std::endl;
#else
    //long * vet;

    //std::cin >> qtt;

    //vet = new long[qtt];
    //loadRandValues(vet, qtt, qtt);
    long vet[] = {10,9,8,7,6,5,4,3,2,1};
#endif // _DEBUG_

#ifdef _RELOAD_
    reloadValues(vet, values, 10);
#endif // _RELOAD_

#ifdef _BUBBLESORT_
    std::cout << "\nBubbleSort - " << qtt << " elementos serao ordenados\n";
    BubbleSort(vet, qtt);
    show_color(vet, qtt, 0, 0);
#endif // _BUBBLESORT_

#ifdef _RELOAD_
    reloadValues(vet, values, 10);
#endif // _RELOAD_

#ifdef _SELECTIONSORT_
    std::cout << "\nSelectionSort - " << qtt << " elementos serao ordenados\n";
    SelectionSort(vet, qtt);
    show_color(vet, qtt, 0, 0);
#endif // _SELECTIONSORT_

#ifdef _RELOAD_
    reloadValues(vet, values, 10);
#endif // _RELOAD_

#ifdef _INSERTIONSORT_
    std::cout << "\nInsertionSort - " << qtt << " elementos serao ordenados\n";
    InsertionSort(vet, qtt);
    show_color(vet, qtt, 0, 0);
#endif // _INSERTIONSORT_

#ifdef _RELOAD_
    reloadValues(vet, values, 10);
#endif // _RELOAD_

#ifdef _HEAPSORT_
    std::cout << "\nHeapSort - " << qtt << " elementos serao ordenados\n";
    HeapSort(vet, qtt);
    show_color(vet, qtt, 0, 0);
#endif // _HEAPSORT_

#ifdef _RELOAD_
    reloadValues(vet, values, 10);
#endif // _RELOAD_

#ifdef _QUICKSORT_
    std::cout << "\nQuickSort - " << qtt << " elementos serao ordenados\n";
    QuickSort(vet, 0, qtt, qtt);
    show_color(vet, qtt, 0, 0);
#endif // _QUICKSORT_

#ifdef _RELOAD_
    reloadValues(vet, values, 10);
#endif // _RELOAD_

#ifdef _MINMAXSORT_
    std::cout << "\nMinMaxSort - " << qtt << " elementos serao ordenados\n";
    MinMaxSort(vet, qtt);
    show_color(vet, qtt, 0, 0);
#endif // _MIN_MAX_

#ifdef _DEBUG_
    show_color(vet, qtt, 0, 0);
    std::cout << "\n\n\n";
#else
    delete[] vet;
#endif // _DEBUG_

    exit(0);

}
